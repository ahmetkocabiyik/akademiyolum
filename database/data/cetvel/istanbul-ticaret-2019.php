<?php

/**
 * İSTANBUL TİCARET ÜNİVERSİTESİ — Ek 1: Öğretim Elemanı Değerlendirme
 * Kriterleri
 * Kaynak: pdf/17537101122.istanbulticaretuniversitesi.pdf
 *
 * KOŞULLAR ROMEN RAKAMLI BÖLÜMLERE ATIF YAPIYOR ("Değerlendirme
 * Kriterlerindeki I no'lu faaliyetlerden 250 puan"), bu yüzden bölüm numaraları
 * (I, II, III) ve içindeki alt numaralar korundu. Kodlar `I.B.1` biçiminde:
 * bölüm · alt başlık · sıra.
 *
 * "I NO'LU FAALİYETLER" = YAYINLAR bölümünün tamamı: makaleler, bildiriler,
 * kitaplar, çeviriler, editörlük ve atıflar. Yani üç kadroda da aranan alt
 * baraj yalnızca yayın tarafını sayıyor; eğitim-öğretim, proje ve ödüller
 * (II) yalnızca genel toplama giriyor.
 *
 * YAZAR ÇARPANI SADECE KİŞİ SAYISINA BAĞLI (I/A-2): iki yazarlı 0,8; üç
 * yazarlı 0,6; dört ve daha fazla yazarlı 0,5. Sıra rol oynamıyor, bu yüzden
 * bütün roller aynı kademeleri kullanıyor.
 *
 * ── TABLO 01.09.2026'DA KAYNAĞA GÖRE YENİDEN YAZILDI ──
 * Dosya "çok değerli satırlar PDF'te ayrıştırılamadı, en yüksek değerle tek
 * satır girildi" diyordu. `pdftotext -q -layout` ile Ek 1'in TAMAMI temiz
 * çıkıyor — hiçbir değer eksik değil. Tek satıra indirilmiş her kalem kendi
 * kademelerine ayrıldı. Düzeltilen sekiz yer ve yönü:
 *
 *   I/B-5 (teknik not, editöre mektup, özet) tek satırda 5 puandı; yönerge
 *       "adı geçen maddelerde belirtilen puanların YARISI" diyor ve dergi
 *       düzeyi kayıttan okunabiliyor → 30/20/12/5. EKSİK sayıyordu.
 *   I/C-1 ve I/C-2 bildiri satırları tam metin değerinde toplanmıştı; özet ve
 *       poster ayrı satıra alındı (20 → 5 ve 8 → 5). FAZLA sayıyordu.
 *   I/D-5 (editörlük) BÜTÜN dergi, yayın kurulu ve hakemlik etiketlerini tek
 *       satırda 120 puanla topluyordu. Yönerge dört kademe veriyor
 *       (120/70/25/20), yardımcı editörlüğe yarısını, hakemliğe beşte birini.
 *       Hakemlik kaydı olan aday 120 puan görüyordu; artık 4. EN BÜYÜK HATA.
 *   I/D-5-g kitap editörlüğü (yurt dışı 50 / yurt içi 30) I/D-3'ün derleme
 *       satırında 10 puanla duruyordu. EKSİK sayıyordu.
 *   I/D-6 (atıflar) bütün atıf etiketlerini 10 puanla sayıyordu; yönerge
 *       10/5/3/2 diyor. FAZLA sayıyordu.
 *   II/B-1 ve II/B-4'te SATIR DEĞERİ OLARAK TAVAN YAZILMIŞTI: her tamamlanan
 *       tez 75, her jüri üyeliği 50 puan alıyordu. Yönerge doktora tezine 10,
 *       yüksek lisansa 5, jüriye 2-5 veriyor; 75 ve 50 bölümün TOPLAM sınırı.
 *       İki tez yöneten aday 150 puan görüyordu. ÇOK FAZLA sayıyordu.
 *   II/D-7 (patent) bütün patent etiketlerini 50 puanla sayıyordu; yönerge
 *       uluslararası 50 / ulusal 20 diyor. FAZLA sayıyordu.
 *   III bölümünün alt kırılımları (a/b çiftleri) girilmemişti; dört satırın
 *       hepsi yüksek değerdeydi. Ayrıldı: III-1 5/10, III-2 20/10, III-3 8/5,
 *       III-4 100/80, III-5 30/20. FAZLA sayıyordu.
 *
 * TAVANLAR ARTIK UYGULANIYOR: "Toplamı 75 puanı aşamaz" (II/A ve II/B-1) ve
 * "Toplamı 50 puanı aşamaz" (II/B-4) sınırları `grup_tavanlari` ile girildi.
 * Değerler kaynakta kesik değil; eski notun tersine üçü de okunabiliyor.
 *
 * ── DERLEME MAKALE I/B'DE KALDI ──
 * I/D-3 "Derleme Çalışmaları — a. Kitap 10, b. Makale 5" diyor ve "Kitaplar"
 * başlığının altında duruyor; bu bağlamda derleme = derlenmiş/hazırlanmış eser.
 * I/B-1'in parantezi hangi yayın türlerinin makale sayılmadığını KAPALI bir
 * listeyle sayıyor (teknik not, editöre mektup, tartışma, vaka takdimi, özet)
 * ve derleme o listede yok. Bu yüzden derleme makale I/B satırlarında tam
 * puanla kaldı; I/D-3'ün iki satırı kayıtta karşılığı olmadığı için girilmedi.
 *
 * GİRİLMEYEN KALEMLER: II/D-1 ve II/D-2 (sempozyum ve kongre düzenlemede
 * başkanlık ya da görev almak) ile II/D-6 (oturum başkanlığı) — kaynak
 * sözlüğünde karşılıkları yok. II/A'nın "son beş yılda, her yarıyılda en fazla
 * üç ders" penceresi ve II/A-d'nin "İngilizce verilen derste puan iki katı"
 * çarpanı motorda karşılanamıyor; ders puanı yalnızca 75'lik tavanla sınırlı.
 * II/B-4-c (YÖK doçentlik jüri görevlendirmesi, 5) kayıtta ayrı tutulmuyor. II/B-2 (bir yıldan fazla yürütülen ama TAMAMLANMAMIŞ doktora
 * tezi, 4 puan) da girilmedi: kayıt yalnızca tamamlanmış tezleri tutuyor,
 * eski cetvelde bu satır eş danışmanlık rolüne bağlanmıştı ve eş danışmanlara
 * yanlış puan veriyordu.
 *
 * KODLAR BİZE AİT — KAYNAKTA SATIR KODU YOK. Cetvel kodlarının SAYISAL
 * ÇEKİRDEĞİ kaynağın madde/bölüm numarasıdır; baştaki harf tabloyu ya da
 * eki, sondaki harf şıkkı gösterir ve ikisi de bizim eklediğimiz parçadır.
 * Koşullar bu kodlara atıf yaptığı için değiştirilmemeli; kaynakla
 * karşılaştırırken kodun sayısal çekirdeğine bakılmalı.
 */

return [
    'kapsam_notu' => 'Puanlar İstanbul Ticaret Üniversitesi Ek 1 Değerlendirme Kriterlerinden. '
        .'Puan KİŞİ SAYISINA göre azaltılır (iki yazarlı 0,8 · üç yazarlı 0,6 · dört ve '
        .'fazlası 0,5); sıranız fark etmiyor. Öğretim faaliyetleri ve tez yönetimi en fazla 75, '
        .'tez jüriliği en fazla 50 puan sayılıyor. YARDIMCI EDİTÖRLÜK VE HAKEMLİK PUANINIZ '
        .'DÜŞÜK GÖRÜNEBİLİR: yönerge bu görevlere ilgili derginin editörlük puanının yarısını '
        .'ve beşte birini veriyor, faaliyet kaydı dergi düzeyini taşımadığı için en düşük '
        .'kademeden hesaplandı. Burs ve tez jüriliği de aynı nedenle en düşük satırdan '
        .'sayılıyor.',

    // I/A-2 — çok yazarlı çalışmalarda puan oranı; yalnızca kişi sayısına bağlı.
    'yazar_katsayisi' => [
        'haric' => ['atif', 'proje', 'patent', 'editorluk', 'odul', 'egitim_ogretim',
            'tez_danismanligi', 'idari_gorev', 'toplumsal_katki', 'sanatsal_etkinlik'],
        'roller' => (function (): array {
            $k = ['kademeler' => [1 => 1.0, 2 => 0.80, 3 => 0.60], 'sonrasi' => 0.50];

            return [
                'tek' => ['kademeler' => [1 => 1.0]],
                'ilk' => $k, 'baslica' => $k, 'yazar_2' => $k, 'yazar_3' => $k,
                'yazar_4' => $k, 'yazar_5' => $k, 'yazar_6' => $k, 'ortak' => $k,
            ];
        })(),
    ],

    'maddeler' => [
        // ══ I/B — MAKALELER ══
        'I.B.1' => ['baslik' => 'SCI, SSCI veya AHCI dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 60],
        'I.B.2' => ['baslik' => 'Diğer indeksli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 40],
        'I.B.3' => ['baslik' => 'Hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 25],
        'I.B.4' => ['baslik' => 'Diğer bilimsel dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 10],
        // I/B-5: teknik not, editöre mektup, vaka takdimi ve özet türü yayınlar
        // "adı geçen maddelerde belirtilen puanların YARISI" — dergi düzeyi kayıttan
        // okunduğu için oran her satıra ayrı ayrı uygulandı (kesirli puan aşağı yuvarlandı).
        'I.B.5.a' => ['baslik' => 'SCI, SSCI veya AHCI dergide teknik not, editöre mektup, vaka takdimi ya da özet', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 30],
        'I.B.5.b' => ['baslik' => 'Diğer indeksli dergide teknik not, editöre mektup, vaka takdimi ya da özet', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 20],
        'I.B.5.c' => ['baslik' => 'Hakemli dergide teknik not, editöre mektup, vaka takdimi ya da özet', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 12],
        'I.B.5.d' => ['baslik' => 'Diğer bilimsel dergide teknik not, editöre mektup, vaka takdimi ya da özet', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => ['vaka_teknik_not', 'kisa_makale'], 'puan' => 5],

        // ══ I/C — BİLDİRİLER ══
        'I.C.1.a' => ['baslik' => 'Uluslararası bilimsel toplantıda tam metin olarak yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin', 'Uluslararası Tam Metin (CPCI)'], 'puan' => 20],
        // Özet bildiri 10, poster ve sözlü sunum 5; kayıt ikisini ayırmıyor → §0 uyarınca 5.
        'I.C.1.c' => ['baslik' => 'Uluslararası bilimsel toplantıda özet bildiri, poster ya da sözlü sunum', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 5],
        'I.C.2.a' => ['baslik' => 'Ulusal bilimsel toplantıda tam metin olarak yayımlanan bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 8],
        'I.C.2.c' => ['baslik' => 'Ulusal bilimsel toplantıda özet bildiri, poster ya da sözlü sunum', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 5],

        // ══ I/D — KİTAPLAR, ÇEVİRİLER, EDİTÖRLÜK, ATIFLAR ══
        'I.D.1.a' => ['baslik' => 'Alanında yurt dışında yayımlanan kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 100],
        'I.D.1.b' => ['baslik' => 'Alanında yurt içinde yayımlanan kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Ders / Metot Kitabı'], 'puan' => 80],
        'I.D.2.a' => ['baslik' => 'Alanında yurt dışında yayımlanan kitapta bölüm ya da ünite yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 30],
        'I.D.2.b' => ['baslik' => 'Alanında yurt içinde yayımlanan kitapta bölüm ya da ünite yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü', 'Ansiklopedi Maddesi'], 'puan' => 20],
        'I.D.4.a' => ['baslik' => 'Alanında kitap çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 40],
        'I.D.4.b' => ['baslik' => 'Alanında makale, kitap bölümü ya da karar tahlili çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 10],
        // I/D-5 — editörlük dergi düzeyine göre dört kademeli.
        'I.D.5.a' => ['baslik' => 'SCI, SSCI veya AHCI dergide editörlük (her yıl için)', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 120],
        'I.D.5.b' => ['baslik' => 'Diğer uluslararası indeksli dergide editörlük (her yıl için)', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 70],
        'I.D.5.c' => ['baslik' => 'Hakemli bilimsel veya mesleki dergide editörlük (her yıl için)', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi'], 'puan' => 25],
        'I.D.5.d' => ['baslik' => 'Diğer bilimsel veya mesleki dergide editörlük (her yıl için)', 'kategori' => 'editorluk', 'kaynaklar' => ['Diğer Hakemli Dergi'], 'puan' => 20],
        // I/D-5-e: yardımcı ve konuk editörlük ilgili maddenin YARISI; I/D-5-f: hakemlik
        // BEŞTE BİRİ. Kayıt bu görevlerde dergi düzeyini taşımadığı için §0 uyarınca
        // en düşük editörlük satırından (20) hesaplandı: 20/2 = 10 ve 20/5 = 4.
        'I.D.5.e' => ['baslik' => 'Dergide yardımcı editörlük veya konuk editörlük (her yıl için)', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 10],
        'I.D.5.f' => ['baslik' => 'Dergi hakemliği (her yıl en fazla 5 adet)', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 4],
        'I.D.5.g.i' => ['baslik' => 'Alanında yurt dışında yayımlanan kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 50],
        'I.D.5.g.ii' => ['baslik' => 'Alanında yurt içinde yayımlanan kitap editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 30],
        'I.D.6.a' => ['baslik' => 'SCI, SSCI veya AHCI dergisinde atıf (atıf başına)', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 10],
        'I.D.6.c' => ['baslik' => 'Hakemli dergide atıf (atıf başına)', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 3],
        'I.D.6.d' => ['baslik' => 'Kitap veya diğer yayınlarda atıf (atıf başına)', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap', 'Diğer'], 'puan' => 2],

        // ══ II/A — ÖĞRETİM FAALİYETLERİ (toplamı 75 puanı aşamaz) ══
        // "Son beş yılda, her yarıyılda en fazla üç ders" sınırı motorda karşılığı
        // olmayan bir pencere; yalnızca 75 puanlık grup tavanı uygulanıyor.
        'II.A.a' => ['baslik' => 'Verilen doktora dersi (yarıyıl ve ders başına)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 4],
        'II.A.c' => ['baslik' => 'Verilen ön lisans veya lisans dersi (yarıyıl ve ders başına)', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 2],

        // ══ II/B — TEZ YÖNETİMİ VE JÜRİ ══
        'II.B.1.a' => ['baslik' => 'Yönetiminde tamamlanan doktora tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 10],
        'II.B.1.b' => ['baslik' => 'Yönetiminde tamamlanan yüksek lisans tezi', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 5],
        // II/B-3: ikinci danışmanlıkta puanın yarısı (10/2 = 5 ve 5/2 → 2).
        'II.B.3.a' => ['baslik' => 'Tamamlanan doktora tezinde ikinci danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 5],
        'II.B.3.b' => ['baslik' => 'Tamamlanan yüksek lisans tezinde ikinci danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 2],
        // Doktora jürisi 3, tezli yüksek lisans jürisi 2, doçentlik jüriliği 5;
        // kayıt jüri türünü ayırmadığı için §0 uyarınca 2.
        'II.B.4' => ['baslik' => 'Jüride bulunulan ve savunulan tez', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 2],

        // ══ II/C — SONUÇLANDIRILMIŞ ARAŞTIRMA PROJELERİ ══
        'II.C.1' => ['baslik' => 'Uluslararası kuruluşlarca desteklenen projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 30],
        'II.C.2' => ['baslik' => 'Uluslararası kuruluşlarca desteklenen projede görev almak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 12],
        'II.C.3' => ['baslik' => 'Ulusal kuruluşlarca desteklenen projede yürütücülük', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'BAP (Üniversite)', 'Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 15],
        'II.C.4' => ['baslik' => 'Ulusal kuruluşlarca desteklenen projede görev almak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'BAP (Üniversite)', 'Özel Sektör / STK', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 8],

        // ══ II/D — DİĞER BİLİMSEL ETKİNLİKLER ══
        // Uluslararası burs 10, ulusal burs 5; kayıt ikisini ayırmıyor → §0 uyarınca 5.
        'II.D.4' => ['baslik' => 'Alanında bilimsel araştırma için burs almak', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 5],
        'II.D.5' => ['baslik' => 'Panel, konferans, seminer veya söyleşide konuşmacı ya da panelist olmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 5],
        'II.D.7.a' => ['baslik' => 'Uluslararası patentlenmiş buluş', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 50],
        'II.D.7.b' => ['baslik' => 'Ulusal patentlenmiş buluş', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent', 'Faydalı Model', 'Endüstriyel Tasarım', 'Islahçı Hakkı / Çeşit Tescili'], 'puan' => 20],

        // ══ II/E — ÖDÜLLER ══
        'II.E.1' => ['baslik' => 'Alanında uluslararası bilimsel nitelikli ödül', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 50],
        'II.E.2' => ['baslik' => 'Alanında ulusal bilimsel nitelikli ödül', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü', 'Yarışma Derecesi / Mansiyon'], 'puan' => 20],

        // ══ III — SANATSAL ETKİNLİKLER ══
        'III.1.a' => ['baslik' => 'Ulusal karma sanat etkinliğine özgün yapıtla katılma', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Jürisiz, Ulusal)', 'Elektronik Karma Sergi (Ulusal)'], 'puan' => 5],
        'III.1.b' => ['baslik' => 'Uluslararası karma sanat etkinliğine özgün yapıtla katılma', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma Etkinlik (Yurt Dışı, Jürisiz)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Elektronik Karma Sergi (Uluslararası)'], 'puan' => 10],
        'III.2.a' => ['baslik' => 'Uluslararası seçici kurullu sergi, festival, bienal veya gösteriye eserin kabul edilmesi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Resital (Uluslararası)', 'Solistlik (Uluslararası)', 'Masterclass (Uluslararası)'], 'puan' => 20],
        'III.2.b' => ['baslik' => 'Uluslararası seçici kurullu karma sergi veya tasarım etkinliğine yapıtla katılma', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Uluslararası)', 'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)'], 'puan' => 10],
        'III.3.a' => ['baslik' => 'Ulusal seçici kurullu sergi, festival, bienal veya gösteriye eserin kabul edilmesi', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Sempozyum/Çalıştay/Bienal (Yurt İçi)', 'Resital (Ulusal)', 'Solistlik (Ulusal)', 'Masterclass (Ulusal)'], 'puan' => 8],
        'III.3.b' => ['baslik' => 'Ulusal seçici kurullu karma sergi veya tasarım etkinliğine yapıtla katılma', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Karma/Jürili Etkinlik (Ulusal)'], 'puan' => 5],
        'III.4.a' => ['baslik' => 'Eserin uluslararası seçici kurullu müzede veya eşdeğer kurumda yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt Dışı)'], 'puan' => 100],
        'III.4.b' => ['baslik' => 'Eserin ulusal seçici kurullu müzede veya eşdeğer kurumda yer alması', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Eserin Müzeye Kabulü (Yurt İçi)', 'Eserin Satın Alınması (Yurt İçi)', 'Eserin Yayında Yer Alması / Satın Alınması'], 'puan' => 80],
        'III.5.a' => ['baslik' => 'Alanında özgün uluslararası bireysel sanat veya tasarım etkinliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Uluslararası)', 'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Elektronik Kişisel Sergi (Uluslararası)'], 'puan' => 30],
        'III.5.b' => ['baslik' => 'Alanında özgün ulusal bireysel sanat veya tasarım etkinliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Kişisel Etkinlik (Ulusal)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)', 'Elektronik Kişisel Sergi (Ulusal)', 'Özgün Eser / Beste / Tasarım'], 'puan' => 20],
    ],

    'gruplar' => [
        // Koşulların andığı "I no'lu faaliyetler" = Yayınlar bölümünün tamamı.
        'I' => ['I.*'],
        // Kaynaktaki üç ara toplam sınırı.
        'II.A' => ['II.A.*'],
        'II.B.1' => ['II.B.1.*', 'II.B.3.*'],
        'II.B.4' => ['II.B.4'],
    ],

    'grup_tavanlari' => [
        // "Toplamı 75/50 puanı aşamaz" biçimindeki ara toplam sınırları.
        'II.A' => 75,
        'II.B.1' => 75,
        'II.B.4' => 50,
    ],
];
