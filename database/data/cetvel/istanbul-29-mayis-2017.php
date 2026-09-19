<?php

/**
 * İSTANBUL 29 MAYIS ÜNİVERSİTESİ — MADDE 8 Faaliyet ve Puanlama Tablosu
 * Kaynak: pdf/17537098732.istanbul29mayisuniversitesi.pdf
 * (Senato kararı 30.01.2017; YÖK Genel Kurulu 15.02.2017)
 *
 * Madde kodları bize ait: P ile başlayanlar MADDE 8/1'in (lisansüstü
 * tezlerden üretilmemiş yayınlar) satırları, D ile başlayanlar MADDE 8/2'nin
 * (diğer faaliyetler) satırları. Numaralar tablonun kendi sıralarını izler.
 *
 * ── LİSANSÜSTÜ TEZDEN ÜRETİLMİŞ SATIRLAR YAZILMADI ──
 * Tablo aynı yayın türlerini iki kez veriyor: MADDE 8/1 tezden üretilmemiş
 * yayınlar (yüksek puan), MADDE 8/2'nin ilk sekiz satırı tezden üretilmiş
 * olanlar (düşük puan). Faaliyet kaydı yayının tez kökenli olup olmadığını
 * taşımıyor. Doçentlik ve profesörlük eşiklerinin ALT BARAJI doğrudan
 * "8 inci maddesinin 1 inci fıkrasında belirtilen çalışmalar" üzerinden
 * yazıldığı için, düşük satırları seçmek o barajı fiilen ulaşılamaz
 * kılardı; KONVANSIYONLAR §1'in istisnası uygulanarak 8/1 satırları
 * (yüksek değerler) girildi ve 8/2'nin 1-8. satırları hiç yazılmadı.
 * Tezinizden ürettiğiniz yayınlar bu yüzden olduğundan YÜKSEK puanlanıyor.
 *
 * ── AYNI KAYNAK ETİKETİNE DÜŞEN SATIRLARDA DÜŞÜK OLAN GİRİLDİ (§0) ──
 *   Atıfta diğer uluslararası endeks (2) ile ulusal dergi ve kitap (1)
 *       ayrışmıyor → 1.
 *   Hakemlikte üç kademe (8 · 4 · 2) tek 'Hakemlik' etiketine düşüyor → 2.
 *   Tez jürisi üyeliklerinde doktora (2) ile yüksek lisans (1) → 1.
 *   Bilimsel toplantı görevleri (düzenleme kurulu başkanlığı 20'den oturum
 *       başkanlığı 3'e) ile kongre kitapçığı editörlüğü (7 ve 5) tek 'Diğer'
 *       etiketine düşüyor → 3.
 *   Mesleki birikim satırları (uluslararası başkanlık 15'ten ulusal etkinlik
 *       görevi 4'e) → 4.
 *   İdari görevlerde kurul üyeliği (5) ile komisyon üyeliği (4) → 4.
 *
 * ── GİRİLMEYEN SATIRLAR ──
 *   MADDE 8/1'in 3. satırı (diğer uluslararası hakemli dergilerde makale,
 *       25 puan) — indekssiz uluslararası derginin sözlükte karşılığı yok;
 *       'Diğer Uluslararası İndeks' etiketi 2. satıra bağlı.
 *   MADDE 8/2'nin 1-8. satırları (lisansüstü tezlerden üretilmiş kitap,
 *       kitap bölümü ve makaleler) — yukarıda açıklandı.
 *   69 ve 70 (Erasmus yurt dışı görevi, yurt dışında geçirilen yarıyıl) ile
 *       71 (YÖK, TÜBİTAK, DPT, TÜBA kurul üyeliği) — sözlükte karşılıksız
 *       ya da süre ölçütü.
 *
 * ── MOTORUN KARŞILAYAMADIĞI KURALLAR ──
 *   40-42. satırların "son 3 yılda verilen her bir ders" penceresi ile
 *       52-58 ve 63-71. satırların "her yıl için" çarpanı: kayıt görev
 *       süresini taşımadığı için her görev bir kez sayılıyor, çok yıllık
 *       idari görev ve üyeliklerde puanınız DÜŞÜK görünür.
 *
 * Yönerge: yonerge/istanbul-29-mayis.php
 *
 * TANINMIŞ YAYINEVİ AYRIMI KAPSAM ETİKETİNE BAĞLANDI (19.09.2026): kaynak
 * kitabı ve bölümü "tanınmış ULUSLARARASI yayınevi" ↔ "tanınmış ULUSAL
 * yayınevi" diye ayırıyor; sıfat iki kademede de aynı, ayrımı yapan tek şey
 * yayınevinin kapsamı. Kapsamlı etiketler üst satırlara bağlandı, ulusal
 * satırlar daraltıldı.
 */
$TAM = ['ozgun_makale', 'derleme'];
$KISA = ['kisa_makale', 'vaka_teknik_not'];
$WOS = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'];
$ENDEKS = ['ESCI / Scopus', 'Diğer Uluslararası İndeks'];

$maddeler = [
    // ══ MADDE 8/1 — LİSANSÜSTÜ TEZLERDEN ÜRETİLMEMİŞ YAYIN ══
    'P1' => ['baslik' => 'SCI-Expanded, SSCI veya AHCI kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => $WOS, 'turler' => $TAM, 'puan' => 40],
    'P2' => ['baslik' => 'SCI-Expanded, SSCI ve AHCI dışındaki uluslararası alan endekslerinde taranan dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => $ENDEKS, 'turler' => $TAM, 'puan' => 30],
    'P4' => ['baslik' => 'Tanınmış uluslararası yayınevi tarafından yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap', 'Uluslararası Kitap'], 'puan' => 50],
    'P5' => ['baslik' => 'Tanınmış uluslararası yayınevi tarafından yayımlanmış kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü', 'Uluslararası Kitap Bölümü'], 'puan' => 25],
    'P6' => ['baslik' => 'ULAKBİM (TR Dizin) tarafından taranan ulusal hakemli dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $TAM, 'puan' => 25],
    'P7' => ['baslik' => 'Diğer ulusal hakemli dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $TAM, 'puan' => 20],
    'P8' => ['baslik' => 'Tanınmış ulusal yayınevi tarafından yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Ulusal Kitap', 'Tahkik (Tenkitli Metin)'], 'puan' => 40],
    'P9' => ['baslik' => 'Tanınmış ulusal yayınevi tarafından yayımlanmış kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['Ulusal Kitap Bölümü'], 'puan' => 20],

    // ══ MADDE 8/2 — DİĞER FAALİYETLER ══
    'D09' => ['baslik' => 'Uluslararası bilimsel toplantıda sözlü sunulan ve tam metin yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 15],
    'D10' => ['baslik' => 'Uluslararası bilimsel toplantıda sözlü sunum, yayımlanmış özet ya da poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster', 'Davetli Konuşmacı'], 'puan' => 8],
    'D11' => ['baslik' => 'Ulusal bilimsel toplantıda sözlü sunulan ve tam metin yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 10],
    'D12' => ['baslik' => 'Ulusal bilimsel toplantıda sözlü sunum, yayımlanmış özet ya da poster bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 5],
    'D13' => ['baslik' => 'Ders kitabı', 'kategori' => 'kitap', 'kaynaklar' => ['Ders / Metot Kitabı'], 'puan' => 20],
    'D14' => ['baslik' => 'Yayımlanmış kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 15],
    'D15' => ['baslik' => 'Yayımlanmış makale ya da kitapta bölüm çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 5],
    'D16' => ['baslik' => 'Bilimsel ansiklopedide yayımlanmış madde', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 4],
    'D17' => ['baslik' => 'Uluslararası hakemli dergide yayımlanan editöre mektup, özet ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => [...$WOS, ...$ENDEKS], 'turler' => $KISA, 'puan' => 3],
    'D18' => ['baslik' => 'Ulusal hakemli dergide yayımlanan editöre mektup, özet ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin', 'Diğer Ulusal Hakemli'], 'turler' => $KISA, 'puan' => 2],
    'D19' => ['baslik' => 'SCI-Expanded, SSCI, AHCI dergilerinde ve tanınmış uluslararası yayınevlerince yayımlanmış kitaplarda eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'BKCI Kitap'], 'puan' => 3],
    'D21' => ['baslik' => 'Ulusal hakemli dergilerde ve tanınmış ulusal yayınevlerince yayımlanmış kitaplarda eserinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Diğer', 'Patent'], 'puan' => 1],
    'D22' => ['baslik' => 'Uluslararası kurum ve kuruluşlarca desteklenen tamamlanmış projede proje yöneticiliği', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 50],
    'D23' => ['baslik' => 'Uluslararası kurum ve kuruluşlarca desteklenen tamamlanmış projede yöneticilik dışındaki görev', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 35],
    'D24' => ['baslik' => 'TÜBİTAK, DPT ve benzeri ulusal kurumlarca desteklenen tamamlanmış projede proje yöneticiliği', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['yurutucu'], 'puan' => 40],
    'D25' => ['baslik' => 'TÜBİTAK, DPT ve benzeri ulusal kurumlarca desteklenen tamamlanmış projede yöneticilik dışındaki görev', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 25],
    'D26' => ['baslik' => 'Üniversite bilimsel araştırma projesinde (BAP) proje yöneticiliği', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Özel Sektör / STK', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 20],
    'D27' => ['baslik' => 'Üniversite bilimsel araştırma projesinde (BAP) yöneticilik dışındaki görev', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Özel Sektör / STK', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
    'D28' => ['baslik' => 'SCI-Expanded, SSCI veya AHCI kapsamındaki dergide editörlük ya da genel yönetmenlik', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 15],
    'D29' => ['baslik' => 'Diğer uluslararası alan endekslerinde taranan dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 10],
    'D30' => ['baslik' => 'Ulusal hakemli dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi'], 'puan' => 7],
    'D33' => ['baslik' => 'Tanınmış uluslararası yayınevi tarafından yayımlanmış kitap ya da kitap dizisi editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap', 'Uluslararası Kitap Editörlüğü'], 'puan' => 10],
    'D34' => ['baslik' => 'Tanınmış ulusal yayınevi tarafından yayımlanmış kitap ya da kitap dizisi editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü', 'Ulusal Kitap Editörlüğü'], 'puan' => 7],
    // Kaynakta YAYIN KURULU ÜYELİĞİ satırı YOK; etiket hakemlik satırında
    // duruyordu. İki rol ayrı: hakemlik makale başına, yayın kurulu
    // üyeliği süreklilik taşıyan bir görev. Etiket burada kalsaydı
    // kaynağın vermediği puanı verir ve hakemlik SAYISI koşullarını
    // da beslerdi.
    'D35' => ['baslik' => 'Hakemli dergilerde hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 2],
    'D38' => ['baslik' => 'Tamamlanan doktora tezi danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'puan' => 10],
    'D39' => ['baslik' => 'Tamamlanan yüksek lisans tezi danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'puan' => 5],
    'D43' => ['baslik' => 'Lisansüstü tez savunma ya da tez izleme jürisi üyeliği', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 1],
    'D40' => ['baslik' => 'Lisansüstü seviyede son üç yılda verilen her bir ders', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 2],
    'D41' => ['baslik' => 'Lisans seviyesinde son üç yılda verilen her bir ders', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders'], 'puan' => 1],
    'D42' => ['baslik' => 'Erasmus programı dahil yurt dışında verilen her bir ders', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 2],
    'D46' => ['baslik' => 'Bilimsel toplantılarda düzenleme kurulu ya da oturum başkanlığı, kongre kitapçığı editörlüğü', 'kategori' => 'diger', 'kaynaklar' => ['Diğer'], 'puan' => 3],
    'D52' => ['baslik' => 'Mesleki kurum ve kuruluşlarda görev, mesleki etkinliklerde görev ya da alanında mesleki tecrübe', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Kamu/STK Danışmanlığı', 'Topluma Hizmet Projesi', 'Bilim İletişimi / Popüler Yayın'], 'puan' => 4],
    'D59' => ['baslik' => 'Uluslararası ödül', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 40],
    'D60' => ['baslik' => 'Ulusal ödül', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü', 'Yarışma Derecesi / Mansiyon'], 'puan' => 25],
    'D61' => ['baslik' => 'Uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 40],
    'D62' => ['baslik' => 'Ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent', 'Faydalı Model', 'Endüstriyel Tasarım', 'Yazılım', 'Islahçı Hakkı / Çeşit Tescili', 'Ticarileştirme'], 'puan' => 25],
    'D63' => ['baslik' => 'Rektörlük (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör'], 'puan' => 30],
    'D64' => ['baslik' => 'Rektör yardımcılığı ya da dekanlık (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör Yardımcısı', 'Dekan / Enstitü-YO Müdürü'], 'puan' => 20],
    'D65' => ['baslik' => 'Yüksekokul, enstitü ya da merkez müdürlüğü, dekan yardımcılığı (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Uygulama ve Araştırma Merkezi Müdürü', 'Dekan Yrd. / Müdür Yrd.'], 'puan' => 10],
    'D66' => ['baslik' => 'Müdür yardımcılığı ya da bölüm başkanlığı (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkanı'], 'puan' => 7],
    'D67' => ['baslik' => 'Üniversite, fakülte, yüksekokul ve enstitü kurul üyeliği ile akademik komisyon üyeliği (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Kurul / Komisyon Üyeliği'], 'puan' => 4],
    'D68' => ['baslik' => 'Bölüm başkan yardımcılığı, anabilim dalı başkanlığı ya da akademik koordinatörlük (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Bölüm Başkan Yardımcısı', 'Anabilim Dalı Başkanı / Koordinatörlük'], 'puan' => 4],
];

return [
    'kapsam_notu' => 'Puanlar İstanbul 29 Mayıs Üniversitesi Öğretim Üyeliğine Atama ve '
        .'Yükseltme Kriterlerinin MADDE 8 tablosundan (Senato 30.01.2017, YÖK 15.02.2017). '
        .'Ortak yayınlarda MADDE 4/2 uygulanıyor: başlıca yazar belirtilmişse iki yazarlıda '
        .'başlıca yazar puanın %80\'ini, üç ve daha fazla yazarlıda yarısını alıyor; başlıca '
        .'yazar belirtilmemişse puan yazar sayısına bölünüyor. Kayıt bir eserde BAŞKA birinin '
        .'başlıca yazar olarak gösterilip gösterilmediğini taşımadığı için, kendiniz başlıca '
        .'yazar değilseniz §0 gereği iki okumanın düşük olanı (kalan yarının eşit paylaşımı) '
        .'uygulanıyor. Yazar listesini boş bırakırsanız hiçbir bölme uygulanmaz ve puanınız '
        .'olduğundan yüksek görünür. Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: '
        .'MADDE 8/1\'in 3. satırı (indekssiz uluslararası hakemli dergi, 25 puan) sözlükte '
        .'karşılıksız; hakemlik, tez jürisi, bilimsel toplantı görevleri, mesleki birikim ve '
        .'kurul üyelikleri aynı etikete düştüğü için en düşük değerden sayılıyor; "her yıl '
        .'için" verilen idari görev ve üyelik puanları görev süresiyle çarpılamıyor, her görev '
        .'bir kez sayılıyor. Puanınız şu kalemde OLDUĞUNDAN YÜKSEK görünür: lisansüstü '
        .'tezinizden ürettiğiniz kitap, bölüm ve makaleler için tablonun düşük satırları '
        .'(MADDE 8/2\'nin 1-8. satırları) kayıtta ayrışmadığından tam değerlerden puanlanıyor.',

    // MADDE 4/2. Başlıca yazar dışındaki roller için iki okumanın düşüğü:
    // kalan yarının eşit paylaşımı, yani 0,5 / (yazar sayısı - 1).
    'yazar_katsayisi' => [
        'haric' => ['atif', 'editorluk', 'proje', 'tez_danismanligi', 'tez_yayini',
            'egitim_ogretim', 'idari_gorev', 'toplumsal_katki', 'diger'],
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.00]],
            'baslica' => ['kademeler' => [1 => 1.00, 2 => 0.80], 'sonrasi' => 0.50],
            'ortak' => ['bol' => ['pay' => 0.5, 'eksi' => 1]],
        ],
    ],

    'maddeler' => $maddeler,

    'gruplar' => [
        // MADDE 6 ve 7'nin alt barajı: "8 inci maddesinin 1 inci fıkrasında
        // belirtilen çalışmalar".
        'MADDE-8-1' => ['P1', 'P2', 'P4', 'P5', 'P6', 'P7', 'P8', 'P9'],
        // MADDE 5'in "hakemli dergilerde en az bir makale" koşulu.
        'MAKALE' => ['P1', 'P2', 'P6', 'P7'],
        'TOPLAM' => array_keys($maddeler),
    ],

    'grup_tavanlari' => [],
];
