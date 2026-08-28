<?php

/**
 * LOKMAN HEKİM ÜNİVERSİTESİ — Tablo 1 (Bilimsel Yayınlar) ve Tablo 2
 * (Eğitim-Öğretim, İdari ve Diğer Bilimsel Faaliyetler)
 * Kaynak: pdf/17634002431.Lokman Hekim Üniversitesi Kriter.pdf
 * (23 sayfa; YÖK Genel Kurulu 01.06.2022, değişiklik 21.11.2024)
 *
 * Yönergenin bütün puan koşulları "Tablo 1 ve Tablo 2'den toplamda"
 * biçiminde; ikisi tek cetvelde birleşti. Madde kodları bize ait
 * (`T1-*`, `T2-*`) — tablo satırlarının kendi numarası yok.
 *
 * ── PDF FONT UYARISI ──
 * Belgenin bir kısmında küçük `i` harfi `a` olarak çıkıyor ("Balam alanı
 * ale algala" = "Bilim alanı ile ilgili"). Bozulma yalnızca harflerde;
 * SAYILAR ve tablo puanları etkilenmiyor, tablolar temiz okundu.
 *
 * ── AYNI ETİKETE DÜŞÜP DÜŞÜĞÜ GİRİLEN SATIRLAR ──
 *   Patentte "incelemeli" (120) ile "incelemesiz" (60) ayrımı kayıtta
 *       yok → 60. Başvuru aşamasındaki satırlar (40/20/10) girilmedi.
 *   Bildirilerde "uluslararası" (15/8) ile "uluslararası katılımlı"
 *       (10/4) ayrımı okunamıyor → 10 ve 4.
 *   Davetli konuşmacılıkta uluslararası (25), ulusal (10) ve çalıştay
 *       (5) tek etikete düşüyor → 5.
 *   Dergi görevlerinde editörlük (40/20), yardımcı editörlük (30/15),
 *       yayın kurulu üyeliği (20/10), misafir editörlük (10/5) ve
 *       hakemlik (10/5) ayrımı kısmen okunuyor; yayın kurulu üyeliği 10,
 *       hakemlik 5 puandan sayılıyor.
 *   Ödüllerde uluslararası kongre en iyi bildiri (10) ile ulusal (3),
 *       burslarda uluslararası (10) ile ulusal (5) → en düşükten.
 *   Bilimsel toplantı düzenleme görevleri (30/15/10/5 ve 10/3/2) tek
 *       'Diğer' etiketine düşüyor → 2.
 *   Bilimsel kurul üyeliği (yurt dışı 20, yurt içi 10) ile idari kurul
 *       üyeliği (5) aynı etikete düşüyor → 5.
 *
 * ── GİRİLMEYEN SATIRLAR ──
 *   Hakemsiz dergilerde yayın (5, 1) ve indeksli dergilerde özet (2) —
 *       kayıt hakemsiz dergiyi ayırmıyor.
 *   "Uluslararası ders kitabında adayın adıyla anılan formül, şema,
 *       grafik, tablo ve resimlere yer verilmesi" (40) ve kitap
 *       eleştirisi (10/5) — sözlükte karşılık yok.
 *   Spor branşlarında görev almak (milli takım 20, üniversite takımı
 *       10), soruşturma (5), lisans danışmanlığı, öğrenci proje
 *       yarışmaları ve öğrenci kulübü danışmanlığı (1-2) — karşılıksız.
 *   Alt yapı projesi (10).
 *
 * ── UYGULANMAYAN ARTIRIM: SORUMLU YAZAR ──
 * Tablo 3'ün dipnotu sorumlu (corresponding) yazara "tekabül eden
 * puanın %15'i ilave edilir" diyor. Sorumlu yazarın kaçıncı sırada
 * olduğu kayıttan okunamadığı için §0 uyarınca artırım UYGULANMADI;
 * sorumlu yazarsanız puanınız olduğundan biraz düşük görünür.
 *
 * ── MOTORUN KARŞILAYAMADIĞI SINIRLAR ──
 * "En çok 3 adet/yıl", "en çok 2 adet/yıl", "en çok 1 adet/yıl" gibi
 * YILLIK adet sınırları; madde 24(6)'nın "asgari puanların tamamı aynı
 * maddeden olamaz" kuralı; Tablo 3 dipnotunun "aynı çalışma birden
 * fazla biçimde sunulduysa yalnızca en yüksek puanlı sayılır" kuralı.
 *
 * Yönerge: yonerge/lokman-hekim.php
 */
$SCI = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'];
$OZGUN = ['ozgun_makale'];
$DERLEME = ['derleme'];
$KISA = ['kisa_makale', 'vaka_teknik_not'];

return [
    'kapsam_notu' => 'Puanlar Lokman Hekim Üniversitesi Öğretim Üyeliğine Yükseltilme ve Atanma '
        .'Kriterleri Yönergesinin Tablo 1 ve Tablo 2 listelerinden. Yazar çarpanı Tablo 3\'e '
        .'göre hem yazar sayısına hem yazar sırasına bakıyor: iki yazarlıda ilk isim %85, ikinci '
        .'%70; üç yazarlıda %75/%60/%50; beş ve üzerinde %60/%50/%40/%30/%20 ve altıncıdan '
        .'sonrası %10. Yazar listesini boş bırakırsanız çarpan hiç uygulanmaz ve puanınız '
        .'olduğundan YÜKSEK görünür. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: sorumlu (corresponding) yazara '
        .'verilen %15 artırım, sorumlu yazarın kaçıncı sırada olduğu kayıttan okunamadığı için '
        .'uygulanmıyor. Patentlerde incelemeli (120) ile incelemesiz (60) ayrımı yapılamadığı '
        .'için hepsi 60 puandan; bildirilerde uluslararası (15/8) ile uluslararası katılımlı '
        .'(10/4) ayrımı okunamadığı için 10 ve 4 puandan; davetli konuşmacılık 5, hakemlik 5, '
        .'toplantı düzenleme görevleri 2 puandan sayılıyor. Patent BAŞVURUNUZU kaydetmeyin: '
        .'yönerge ona ayrı ve düşük puan veriyor ama kayıt türü sonuçlanmış patentten '
        .'ayrılamadığı için o satırlar girilmedi. Spor branşlarında görev almak (milli takım 20, '
        .'üniversite takımı 10 puan), hakemsiz dergi yayınları ve kitap eleştirisi sözlükte '
        .'karşılıksız olduğu için girilemedi. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN YÜKSEK görünebilir: "en çok 2-3 adet/yıl" biçimindeki '
        .'yıllık adet sınırları, madde 24(6)\'nın "asgari puanların tamamı aynı maddeden olamaz" '
        .'kuralı ve "aynı çalışma birden fazla biçimde sunulduysa yalnızca en yüksek puanlı '
        .'sayılır" kuralı uygulanmıyor. Atıf satırları yönergede "puan/yazar sayısı" biçiminde '
        .'bölünüyor; atıf kaydı yazar sayısı taşımadığı için bölme yapılmıyor.',

    // Tablo 3: Yazar Katkı Oranlarının Hesaplanması. Sorumlu yazara
    // verilen %15 artırım, sıra bilgisi olmadan uygulanamadığı için
    // 'baslica' dalı 'ilk' ile aynı tutuldu (§0).
    'yazar_katsayisi' => [
        'haric' => ['atif', 'proje', 'editorluk', 'tez_danismanligi', 'egitim_ogretim',
            'odul', 'idari_gorev', 'toplumsal_katki', 'diger', 'sanatsal_etkinlik'],
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.00]],
            'ilk' => ['kademeler' => [1 => 1.00, 2 => 0.85, 3 => 0.75, 4 => 0.70], 'sonrasi' => 0.60],
            'baslica' => ['kademeler' => [1 => 1.00, 2 => 0.85, 3 => 0.75, 4 => 0.70], 'sonrasi' => 0.60],
            'yazar_2' => ['kademeler' => [2 => 0.70, 3 => 0.60, 4 => 0.60], 'sonrasi' => 0.50],
            'yazar_3' => ['kademeler' => [3 => 0.50, 4 => 0.50], 'sonrasi' => 0.40],
            'yazar_4' => ['kademeler' => [4 => 0.40], 'sonrasi' => 0.30],
            'yazar_5' => ['sonrasi' => 0.20],
            'yazar_6' => ['sonrasi' => 0.10],
            'ortak' => ['kademeler' => [1 => 1.00, 2 => 0.70, 3 => 0.50, 4 => 0.40], 'sonrasi' => 0.10],
        ],
    ],

    'maddeler' => [
        // ══ TABLO 1 — ARAŞTIRMA MAKALESİ ══
        'T1-A-sci' => ['baslik' => 'SCI Expanded, SSCI ya da AHCI kapsamındaki dergide yayımlanmış araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => $SCI, 'turler' => $OZGUN, 'puan' => 75],
        'T1-A-esci' => ['baslik' => 'ESCI kapsamındaki dergide yayımlanmış araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $OZGUN, 'puan' => 60],
        'T1-A-indeks' => ['baslik' => 'Diğer uluslararası indekslere giren dergide yayımlanmış araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $OZGUN, 'puan' => 30],
        'T1-A-trdizin' => ['baslik' => 'ULAKBİM TR Dizin kapsamındaki ulusal hakemli dergide yayımlanmış araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $OZGUN, 'puan' => 20],
        'T1-A-hakemli' => ['baslik' => 'Diğer ulusal hakemli dergide yayımlanmış araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $OZGUN, 'puan' => 20],

        // ══ TABLO 1 — DERLEME ══
        'T1-D-sci' => ['baslik' => 'SCI Expanded, SSCI ya da AHCI kapsamındaki dergide yayımlanmış derleme', 'kategori' => 'makale', 'kaynaklar' => $SCI, 'turler' => $DERLEME, 'puan' => 60],
        'T1-D-esci' => ['baslik' => 'ESCI kapsamındaki dergide yayımlanmış derleme', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $DERLEME, 'puan' => 50],
        'T1-D-hakemli' => ['baslik' => 'Ulusal ya da uluslararası hakemli dergide yayımlanmış derleme', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks', 'TR Dizin', 'Diğer Ulusal Hakemli'], 'turler' => $DERLEME, 'puan' => 20],

        // ══ TABLO 1 — DİĞER ÇALIŞMALAR ══
        'T1-C-sci' => ['baslik' => 'SCI Expanded, SSCI ya da AHCI kapsamındaki dergide yayımlanmış teknik not, yorum, vaka raporu ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => $SCI, 'turler' => $KISA, 'puan' => 15],
        'T1-C-esci' => ['baslik' => 'ESCI kapsamındaki dergide yayımlanmış teknik not, yorum, vaka raporu ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $KISA, 'puan' => 10],
        'T1-C-hakemli' => ['baslik' => 'Ulusal ya da uluslararası hakemli dergide yayımlanmış teknik not, yorum, vaka raporu ya da editöre mektup', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks', 'TR Dizin', 'Diğer Ulusal Hakemli'], 'turler' => $KISA, 'puan' => 5],

        // ══ TABLO 1 — PATENT ══
        'T1-P-patent' => ['baslik' => 'Ulusal ya da uluslararası patent (başvuru sonuçlanmış)', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent', 'Ulusal Patent'], 'puan' => 60],
        'T1-P-model' => ['baslik' => 'Faydalı model ya da yeni ürün (başvuru sonuçlanmış)', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model', 'Endüstriyel Tasarım', 'Yazılım', 'Islahçı Hakkı / Çeşit Tescili', 'Ticarileştirme'], 'puan' => 25],

        // ══ TABLO 1 — ARAŞTIRMA PROJESİ ══
        'T1-PR-dis-y' => ['baslik' => 'Yurt dışı destekli araştırma projesinde yürütücü, baş araştırmacı ya da koordinatör olmak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 100],
        'T1-PR-dis-a' => ['baslik' => 'Yurt dışı destekli araştırma projesinde araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 75],
        'T1-PR-ic-y' => ['baslik' => 'Yurt içi, üniversite dışı destekli araştırma projesinde yürütücü, baş araştırmacı ya da koordinatör olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 80],
        'T1-PR-ic-a' => ['baslik' => 'Yurt içi, üniversite dışı destekli araştırma projesinde araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 60],
        'T1-PR-uni-y' => ['baslik' => 'Üniversite destekli araştırma projesinde yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 15],
        'T1-PR-uni-a' => ['baslik' => 'Üniversite destekli araştırma projesinde araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'bursiyer'], 'puan' => 11],
        'T1-PR-dan' => ['baslik' => 'Araştırma projesinde danışmanlık', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon', 'TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK', 'BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['danisman'], 'puan' => 5],

        // ══ TABLO 1 — BİLDİRİLER ══
        'T1-B-tam-u' => ['baslik' => 'Uluslararası toplantıda sunulmuş ve tam metni yayımlanmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 10],
        'T1-B-tam-n' => ['baslik' => 'Ulusal toplantıda sunulmuş ve tam metni yayımlanmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 3],
        'T1-B-ozet-u' => ['baslik' => 'Uluslararası toplantıda sunulmuş ve özeti yayımlanmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 4],
        'T1-B-ozet-n' => ['baslik' => 'Ulusal toplantıda sunulmuş ve özeti yayımlanmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 2],

        // ══ TABLO 1 — KİTAP ══
        'T1-K-u' => ['baslik' => 'Uluslararası bilimsel kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 100],
        'T1-K-n' => ['baslik' => 'Ulusal bilimsel kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)'], 'puan' => 50],
        'T1-K-ders' => ['baslik' => 'Ders kitabı', 'kategori' => 'kitap', 'kaynaklar' => ['Ders / Metot Kitabı'], 'puan' => 30],
        'T1-K-bolum-u' => ['baslik' => 'Uluslararası kitaba bölüm düzeyinde katkıda bulunmak', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 30],
        'T1-K-bolum-n' => ['baslik' => 'Ulusal kitaba bölüm düzeyinde katkıda bulunmak', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 15],
        'T1-K-ansiklopedi' => ['baslik' => 'Ansiklopedide konu ya da madde yazarı olmak', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 10],
        'T1-K-ceviri' => ['baslik' => 'Uluslararası yayınevlerince yabancı dilde basılmış eserin Türkçeye tam çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 50],
        'T1-K-ceviri-b' => ['baslik' => 'Uluslararası yayınevlerince yabancı dilde basılmış eserin bir bölümünün Türkçeye çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 20],
        'T1-K-editor-u' => ['baslik' => 'Uluslararası kitapta editörlük (çeviri editörlüğü dâhil)', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 40],
        'T1-K-editor-n' => ['baslik' => 'Ulusal kitapta editörlük (çeviri editörlüğü dâhil)', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 20],

        // ══ TABLO 2 — DAVETLİ KONUŞMACILIK ══
        'T2-davetli' => ['baslik' => 'Bilimsel toplantıda davetli konuşmacı olmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 5],

        // ══ TABLO 2 — ATIFLAR ══
        'T2-atif-sci' => ['baslik' => 'SCI Expanded, SSCI, AHCI ya da ESCI kapsamındaki dergilerde ve uluslararası kitaplarda eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 5],
        'T2-atif-diger' => ['baslik' => 'Diğer indekslere giren dergilerde ve uluslararası basılmış kongre bildirilerinde eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 3],
        'T2-atif-ulusal' => ['baslik' => 'Hakemli dergiler, tezler, kongre özetleri, bildiri kitapları ve kitaplarda eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Diğer', 'Patent'], 'puan' => 2],

        // ══ TABLO 2 — ÖDÜLLER VE BURSLAR ══
        'T2-odul-u' => ['baslik' => 'Uluslararası bilim ve araştırma ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 50],
        'T2-odul-yok' => ['baslik' => 'YÖK ödülleri (topluma hizmet, uluslararası iş birliği, yerel kalkınmaya katkı)', 'kategori' => 'odul', 'kaynaklar' => ['YÖK Ödülü'], 'puan' => 30],
        'T2-odul-n' => ['baslik' => 'TÜBİTAK, TÜBA, bakanlıklar ve benzeri resmî kuruluşlarca verilen ulusal bilim ve araştırma ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü'], 'puan' => 25],
        'T2-odul-bildiri' => ['baslik' => 'Kongrede en iyi bildiri ödülü (ilk üçe giren)', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 3],
        'T2-burs' => ['baslik' => 'Bilim ve araştırma bursu', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 5],

        // ══ TABLO 2 — DERGİLERDE GÖREV ══
        'T2-editor-u' => ['baslik' => 'Uluslararası süreli hakemli indeksli dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi'], 'puan' => 40],
        'T2-editor-n' => ['baslik' => 'Ulusal süreli hakemli indeksli dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi', 'Diğer Hakemli Dergi'], 'puan' => 20],
        'T2-yayin-kurulu' => ['baslik' => 'Dergide yayın kurulu, bilim kurulu ya da komisyon üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 10],
        'T2-hakemlik' => ['baslik' => 'Dergide hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 5],

        // ══ TABLO 2 — BİLİMSEL TOPLANTI VE DİĞER ══
        'T2-toplanti' => ['baslik' => 'Bilimsel toplantıda düzenleme kurulu başkanlığı, üyeliği, bilim kurulu üyeliği ya da raportörlük', 'kategori' => 'diger', 'kaynaklar' => ['Diğer'], 'puan' => 2],

        // ══ TABLO 2 — İDARİ GÖREVLER ══
        'T2-idari-25' => ['baslik' => 'Rektör, rektör yardımcısı ya da dekan olarak görev yapmak (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör', 'Rektör Yardımcısı', 'Dekan / Enstitü-YO Müdürü'], 'puan' => 25],
        'T2-idari-20' => ['baslik' => 'Yüksekokul, meslek yüksekokulu, enstitü ya da merkez müdürlüğü, başhekimlik (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Uygulama ve Araştırma Merkezi Müdürü'], 'puan' => 20],
        'T2-idari-15' => ['baslik' => 'Dekan yardımcılığı, müdür yardımcılığı ya da bölüm başkanlığı (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.', 'Bölüm Başkanı'], 'puan' => 15],
        'T2-idari-5' => ['baslik' => 'Üniversite yönetim kurulu, senato ve diğer kurul üyelikleri, bölüm başkan yardımcılığı, koordinatörlük, komisyon üyeliği, anabilim dalı başkanlığı (yıl başına)', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Senato / Üniversite Yönetim Kurulu Üyesi', 'Bölüm Başkan Yardımcısı', 'Anabilim Dalı Başkanı / Koordinatörlük', 'Kurul / Komisyon Üyeliği'], 'puan' => 5],

        // ══ TABLO 2 — EĞİTİM-ÖĞRETİM ══
        'T2-ders-yabanci' => ['baslik' => 'Yabancı dilde verilen lisans ya da lisansüstü dersi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Yabancı Dilde Ders'], 'puan' => 10],
        'T2-ders' => ['baslik' => 'Lisansüstü, lisans ya da ön lisans dersi (yılı ve sayısına bakılmaksızın toplam)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Lisans/Önlisans Ders', 'Değişim Programı Dersi'], 'puan' => 5],
        'T2-jurilik' => ['baslik' => 'Lisansüstü tez jüri üyeliği', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 5],
        'T2-usi' => ['baslik' => 'Üniversite-sanayi iş birliği için resmî görevlendirme (yıl başına)', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Kamu/STK Danışmanlığı'], 'puan' => 5],
        'T2-gorev' => ['baslik' => 'İdari ve sosyal aktiviteler için resmî görevlendirme, bilirkişilik, kayyımlık ve eğiticilik', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Topluma Hizmet Projesi', 'Bilim İletişimi / Popüler Yayın'], 'puan' => 2],
        'T2-akreditasyon' => ['baslik' => 'Akreditasyon faaliyetlerinde görev almak', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Akreditasyon Faaliyeti'], 'puan' => 2],

        // ══ TABLO 2 — DANIŞMANLIK ══
        'T2-dan-doktora' => ['baslik' => 'Doktora ya da tıpta uzmanlık tez danışmanlığı (her bir öğrenci)', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 10],
        'T2-dan-yl' => ['baslik' => 'Yüksek lisans tez danışmanlığı (her bir öğrenci)', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 4],
        'T2-dan-es' => ['baslik' => 'Lisansüstü tezlerde eş ya da ikinci danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi', 'Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 2],
    ],

    'gruplar' => [
        // Dr. ilk atanmada sayılan "makale" (özgün araştırma, derleme,
        // vaka serisi ya da vaka raporu).
        'MAKALE' => ['T1-A-sci', 'T1-A-esci', 'T1-A-indeks', 'T1-A-trdizin', 'T1-A-hakemli',
            'T1-D-sci', 'T1-D-esci', 'T1-D-hakemli', 'T1-C-sci', 'T1-C-esci', 'T1-C-hakemli'],
        'OZGUN' => ['T1-A-sci', 'T1-A-esci', 'T1-A-indeks', 'T1-A-trdizin', 'T1-A-hakemli'],
        // "SCI Expanded, SSCI, AHCI veya ESCI kapsamındaki dergiler".
        'SCI-ESCI' => ['T1-A-sci', 'T1-A-esci'],
        // Madde 11(1)-a-2: SCI/SSCI/AHCI/ESCI, ULAKBİM ulusal hakemli ya
        // da uluslararası hakemli dergiler.
        'NITELIKLI' => ['T1-A-sci', 'T1-A-esci', 'T1-A-indeks', 'T1-A-trdizin',
            'T1-D-sci', 'T1-D-esci', 'T1-D-hakemli', 'T1-C-sci', 'T1-C-esci', 'T1-C-hakemli'],
        'ULAKBIM' => ['T1-A-trdizin'],
        'ULUSLARARASI-HAKEMLI' => ['T1-A-indeks'],
        // Madde 11(2): SSCI, SCI Expanded, ESCI, AHCI, SCOPUS, diğer
        // uluslararası hakemli ya da TR Dizin dergilerdeki özgün makale.
        'YENIDEN' => ['T1-A-sci', 'T1-A-esci', 'T1-A-indeks', 'T1-A-trdizin'],

        'PROJE-Y' => ['T1-PR-dis-y', 'T1-PR-ic-y', 'T1-PR-uni-y'],
        'PROJE-A' => ['T1-PR-dis-a', 'T1-PR-ic-a', 'T1-PR-uni-a'],
        // Madde 16(1)-b-3 ve 21(1)-d-4: tek yazarlı ya da editör olarak
        // kitap, veya BKCI kapsamındaki kitapta bölüm yazarlığı.
        'KITAP' => ['T1-K-u', 'T1-K-n', 'T1-K-editor-u', 'T1-K-editor-n', 'T1-K-bolum-u'],
        'TEZ' => ['T2-dan-doktora', 'T2-dan-yl', 'T2-dan-es'],
        'DANISMANLIK' => ['T2-dan-doktora', 'T2-dan-yl', 'T2-dan-es'],
    ],

    // Tablo 2 dipnotu ****: "Danışmanlıklardan alınacak puanlar,
    // toplamda 50 puanı aşamaz."
    'grup_tavanlari' => ['DANISMANLIK' => 50],
];
