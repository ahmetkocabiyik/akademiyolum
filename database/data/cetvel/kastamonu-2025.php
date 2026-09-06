<?php

use App\Enums\Kategori;

/**
 * KASTAMONU ÜNİVERSİTESİ — EK-17: Puanlama Cetveli
 * Kaynak: pdf/1766060294628.kastamonu-kriter-18122025.pdf (52 sayfa;
 * Senato 18.12.2025)
 *
 * MADDE KODLARI YÖNERGENİN KENDİSİ: bölüm numarası + bent harfi (`1a`,
 * `3bcg`, `7e`). Koşullar tam olarak bu kodlarla atıf yapıyor ("Puanlama
 * Cetveli'nin 1/a veya 3/a bendindeki bilimsel hakemli dergilerde en az 2
 * makale"), bu yüzden kodlar birebir korundu ve koşulların andığı bent
 * kümeleri `gruplar` altında tek tek tanımlandı. Bize ait olan tek şey
 * çeyrekliğe göre bölünen 1/a satırının `-Q1..-Q4` ekleri, tek kayda düşen
 * satırların tire ile yazılmış çift kodları (`4f-4g`, `12f-12g`) ve
 * editörlük dalı için açılan `-ed` ekleri.
 *
 * ── TEK CETVEL, ON ALTI FAKÜLTE ──
 * Yönerge puanlamayı tek cetvele bağlıyor; fakülteler yalnızca KOŞULLARDA
 * ayrışıyor (bkz. yonerge/kastamonu.php). Bu yüzden burada tek cetvel var.
 *
 * ── AYNI KAYNAĞA DÜŞÜP DÜŞÜĞÜ GİRİLEN SATIRLAR ──
 *   3/a (tezden üretilmiş SCI-E/SSCI makalesi) çeyrekliğe göre 50-24 puan
 *       taşıyor ama `tez_yayini` kategorisinde çeyreklik ayrımı yok →
 *       en düşük çeyreklik değeri (24) girildi.
 *   3/ç (diğer indeksler, 12) ile 3/ğ (diğer ulusal, 8): tek 'Diğer'
 *       etiketi → 8. Aynı şekilde 3/e ile 3/f vaka takdimi (8/6) → 6.
 *   4/f (açıklamalı çeviri 24) ile 4/g (kitap çevirisi 20) → 20.
 *   5/b (SCI dışı dergiler ve BKCI dışı kitaplar, 4) ile 5/ç (diğer
 *       indeksler, 2): tek 'Diğer' etiketi → 2.
 *   7/e TÜBİTAK yürütücülüğü (40) ile 7/ğ diğer TÜBİTAK projelerinde
 *       yürütücülük (25) tek 'TÜBİTAK' etiketine düşüyor → 25; danışmanlık
 *       (15/10) → 10.
 *   8/d yurt dışı davetli konuşmacılık (10) ile 8/e yurt içi (6) → 6.
 *   9. bölümün bütün satırları "fiziki mekânda / çevrim içi" diye çift
 *       puanlı; kayıt bu ayrımı taşımadığı için hepsi ÇEVRİM İÇİ (düşük)
 *       değerinden girildi.
 *   12/f uluslararası yarışma ödülleri (40/30/20/10) ile 12/g ulusal
 *       (30/20/10/5): tek 'Yarışma Derecesi / Mansiyon' etiketi → 5.
 *   12/a-b-c araştırma bursları (40/30/20) → 20.
 *   13. bölümde editörlük düzeyleri ve hakemlik satırları tek etikete
 *       düştüğü için en düşük değerler alındı (diğer dergiler 6,
 *       hakemlik 4).
 *
 * ── GİRİLMEYEN KALEMLER ──
 *   Patent, faydalı model ve proje BAŞVURU satırları (10/b, 10/ç, 10/e,
 *       7/b, 7/ç, 7/g) — tescilli ve desteklenmiş olandan ayrılamıyor.
 *   Kastamonu Üniversitesi Yayınevi satırları (3/k, 3/l, 4/d, 4/e) ve KÜ
 *       dergileri (13/d, 13/e) — kuruma özel, sözlükte karşılık yok.
 *   9. bölümün antrenörlük, spor hakemliği, halkla ilişkiler ve reklam
 *       satırları; 10. bölümün marka tescili, TTO buluş bildirimi,
 *       teknopark ortaklığı ve laboratuvar kurma satırları; 11. bölümün
 *       ders materyali, atama jürisi ve eğitici konuşmacılık satırları;
 *       7/d Ulusal Ajans, 7/i BAP değerlendirme, 7/n COST üyeliği —
 *       sözlükte karşılık yok.
 *   3. bölümün çeviri ve ansiklopedi satırları — `tez_yayini`
 *       kategorisinde çeviri ve ansiklopedi etiketi yok.
 *   14. madde (Diğer Faaliyetler) PUANLAMAYA DÂHİL DEĞİL; yönergenin
 *       kendisi "puanlamaya dâhil olmayan faaliyetler" diyor. Koşulları
 *       yönerge dosyasında `Kalip::hesaplanamiyor` ile işaretlendi.
 *
 * ── MOTORUN KARŞILAYAMADIĞI KURALLAR ──
 *   11. bölümün idari görev satırları "16/Yıl", "12/Yıl", "8/Yıl"
 *       biçiminde ve "en fazla 3/5 yıl puanlanabilir" tavanı taşıyor; yıl
 *       biriktirmesi motorda yok, görev başına tek yıl sayılıyor ve puan
 *       OLDUĞUNDAN DÜŞÜK görünür. Aynı şey 13. bölümün dergi görevleri
 *       için de geçerli.
 *   "Aynı kitapta en fazla 2 bölüm", "aynı yıl içerisinde en fazla N
 *       faaliyet", "aynı proje sadece 1 defa" gibi eser ve yıl bazlı
 *       sınırlar uygulanmıyor.
 *   10. bölüm dipnotu "patentlerde puan kişi sayısına bölünür" derken
 *       yazar tablosu SIRAYA bağlı; tek matris yazılabildiği için sıraya
 *       bağlı olan alındı ve çok buluşçulu patentin puanı bölünmüyor
 *       (en çok 40 puanlık sapma). `kapsam_notu` uyarıyor.
 *
 * Yönerge: yonerge/kastamonu.php
 *
 * KODLAR BİZE AİT — KAYNAKTA SATIR KODU YOK. Cetvel kodlarının SAYISAL
 * ÇEKİRDEĞİ kaynağın madde/bölüm numarasıdır; baştaki harf tabloyu ya da
 * eki, sondaki harf şıkkı gösterir ve ikisi de bizim eklediğimiz parçadır.
 * Koşullar bu kodlara atıf yaptığı için değiştirilmemeli; kaynakla
 * karşılaştırırken kodun sayısal çekirdeğine bakılmalı.
 */
$OZGUN = ['ozgun_makale', 'derleme'];
$KRITIK = ['kisa_makale'];
$VAKA = ['vaka_teknik_not'];

$sanatKisiselU = ['Kişisel Etkinlik (Uluslararası)', 'Elektronik Kişisel Sergi (Uluslararası)',
    'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)',
    'Resital (Uluslararası)', 'Solistlik (Uluslararası)', 'Şan Resitali (Uluslararası)',
    'Opera Birinci Rol (Uluslararası)', 'Orkestra Şefliği (Uluslararası)',
    'Koro Şefliği (Uluslararası)', 'Masterclass (Uluslararası)'];
$sanatKarmaU = ['Karma/Jürili Etkinlik (Uluslararası)', 'Elektronik Karma Sergi (Uluslararası)',
    'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)',
    'Oda Müziği Grup Üyeliği (Uluslararası)', 'Corps de Ballet (Uluslararası)',
    'Sempozyum/Çalıştay/Bienal (Yurt Dışı)'];
$sanatKisiselN = ['Kişisel Etkinlik (Ulusal)', 'Elektronik Kişisel Sergi (Ulusal)',
    'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Kişisel Etkinlik (Yurt İçi, Jürisiz)',
    'Resital (Ulusal)', 'Solistlik (Ulusal)', 'Şan Resitali (Ulusal)',
    'Opera Birinci Rol (Ulusal)', 'Orkestra Şefliği (Ulusal)', 'Koro Şefliği (Ulusal)',
    'Masterclass (Ulusal)'];
$sanatKarmaN = ['Karma/Jürili Etkinlik (Ulusal)', 'Elektronik Karma Sergi (Ulusal)',
    'Karma Etkinlik (Jürisiz, Ulusal)', 'Karma Etkinlik (Yurt Dışı, Jürisiz)',
    'Oda Müziği Grup Üyeliği (Ulusal)', 'Corps de Ballet (Ulusal)', 'Orkestra / Koro Üyeliği',
    'Sempozyum/Çalıştay/Bienal (Yurt İçi)'];
$sanatKayit = ['Albüm / Konser Kaydı', 'Bandrollü Kayıt (CD/DVD)', 'Karma Albüm / CD-DVD Katkısı'];
$sanatHaberU = ['Eserin Haber Olması (Uluslararası)'];
$sanatHaberN = ['Eserin Haber Olması (Ulusal)'];
$sanatYonetmen = ['Yönetmenlik (Sahne/Ekran)', 'Rejisörlük (Uluslararası)', 'Rejisörlük (Ulusal)',
    'Rejisörlük (Konservatuvar)', 'Rejisör Yardımcılığı (Uluslararası)',
    'Rejisör Yardımcılığı (Ulusal)', 'Rejisör Yardımcılığı (Konservatuvar)'];
$sanatFilmU = ['Belgesel/Kısa Film (Uluslararası)'];
$sanatFilmN = ['Belgesel/Kısa Film (Ulusal)'];
$sanatYapimU = ['Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)'];
$sanatYapimN = ['Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)'];
$sanatJuri = ['Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)',
    'Jüri Başkanlığı (Ulusal)', 'Jüri Üyeliği (Ulusal)'];

$sanatKullanilan = array_merge($sanatKisiselU, $sanatKarmaU, $sanatKisiselN, $sanatKarmaN,
    $sanatKayit, $sanatHaberU, $sanatHaberN, $sanatYonetmen, $sanatFilmU, $sanatFilmN,
    $sanatYapimU, $sanatYapimN, $sanatJuri);
$sanatKalan = array_values(array_diff(Kategori::SanatselEtkinlik->kaynaklar(), $sanatKullanilan));

$maddeler = [
    // ══ 1. ULUSLARARASI MAKALELER ══
    '1a-Q1' => ['baslik' => 'SCI-E veya SSCI kapsamındaki Q1 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'turler' => $OZGUN, 'puan' => 50],
    '1a-Q2' => ['baslik' => 'SCI-E veya SSCI kapsamındaki Q2 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'turler' => $OZGUN, 'puan' => 40],
    '1a-Q3' => ['baslik' => 'SCI-E veya SSCI kapsamındaki Q3 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'turler' => $OZGUN, 'puan' => 32],
    '1a-Q4' => ['baslik' => 'SCI-E veya SSCI kapsamındaki Q4 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'turler' => $OZGUN, 'puan' => 24],
    '1b' => ['baslik' => 'AHCI kapsamındaki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['AHCI'], 'turler' => $OZGUN, 'puan' => 24],
    '1c' => ['baslik' => 'ESCI veya Scopus kapsamındaki dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => $OZGUN, 'puan' => 20],
    '1ç' => ['baslik' => 'Diğer uluslararası indekslerde taranan dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'turler' => $OZGUN, 'puan' => 12],
    '1d' => ['baslik' => 'Uluslararası indeksli dergide editöre mektup, özet ya da kitap kritiği', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI', 'ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => $KRITIK, 'puan' => 8],
    '1e' => ['baslik' => 'SCI-E veya SSCI kapsamındaki dergide vaka takdimi', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)'], 'turler' => $VAKA, 'puan' => 8],
    '1f' => ['baslik' => 'Diğer dergilerde vaka takdimi', 'kategori' => 'makale', 'kaynaklar' => ['AHCI', 'ESCI / Scopus', 'Diğer Uluslararası İndeks', 'TR Dizin', 'Diğer Ulusal Hakemli'], 'turler' => $VAKA, 'puan' => 6],

    // ══ 2. ULUSAL MAKALELER ══
    '2a' => ['baslik' => 'ULAKBİM TR Dizin tarafından taranan dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $OZGUN, 'puan' => 20],
    '2b' => ['baslik' => 'Diğer ulusal hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $OZGUN, 'puan' => 8],

    // ══ 3. LİSANSÜSTÜ TEZLERDEN ÜRETİLMİŞ YAYINLAR ══
    '3a' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, SCI-E, SSCI veya AHCI kapsamındaki dergide makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['SCIE/SSCI/AHCI'], 'puan' => 24],
    '3c' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, ESCI veya Scopus kapsamındaki dergide makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['ESCI / Scopus'], 'puan' => 20],
    '3g' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, ULAKBİM TR Dizin tarafından taranan dergide makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['TR Dizin'], 'puan' => 20],
    '3ğ' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, diğer hakemli dergide makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Diğer'], 'puan' => 8],
    '3h' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, BKCI\'da taranmış bilimsel kitap', 'kategori' => 'tez_yayini', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 50],
    '3ı' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, BKCI\'da taranmış kitapta editörlük ya da bölüm yazarlığı', 'kategori' => 'tez_yayini', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 30],
    '3i' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, BKCI dışında bilimsel kitap', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 40],
    '3j' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, BKCI dışında kitapta editörlük ya da bölüm yazarlığı', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 20],
    '3-bildiri' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, bilimsel toplantıda sunulmuş ve tam metni yayımlanmış bildiri', 'kategori' => 'tez_yayini', 'kaynaklar' => ['CPCI Bildiri'], 'puan' => 8],

    // ══ 4. KİTAPLAR ══
    '4a' => ['baslik' => 'BKCI\'da taranmış bilimsel kitap yayımlamak', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 50],
    '4b' => ['baslik' => 'BKCI\'da taranmış kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 30],
    '4b-ed' => ['baslik' => 'BKCI\'da taranmış kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 30],
    '4c' => ['baslik' => 'BKCI dışında bilimsel kitap yayımlamak', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)', 'Ders / Metot Kitabı'], 'puan' => 40],
    '4ç' => ['baslik' => 'BKCI dışında kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 20],
    '4ç-ed' => ['baslik' => 'BKCI dışında kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 20],
    '4f-4g' => ['baslik' => 'Alanınızla ilgili bilimsel kitap çevirisi ya da transkripsiyonu yayımlamak', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'puan' => 20],
    '4ğ' => ['baslik' => 'Çeviri kitapta editörlük, kitap bölümü ya da makale çevirisi', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 10],
    '4ı' => ['baslik' => 'Bilimsel ansiklopedide konu ya da madde yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 6],

    // ══ 5. ATIFLAR ══
    '5a' => ['baslik' => 'SCI-E, SSCI veya AHCI dergilerinde ya da BKCI kitaplarında eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'BKCI Kitap'], 'puan' => 5],
    '5c' => ['baslik' => 'ULAKBİM TR Dizin tarafından taranan dergilerde eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 3],
    '5ç' => ['baslik' => 'Diğer indekslerde taranan dergilerde ya da kitaplarda eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer'], 'puan' => 2],
    '5d' => ['baslik' => 'İncelemeli patentlerde eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Patent'], 'puan' => 4],

    // ══ 6. LİSANSÜSTÜ TEZ DANIŞMANLIKLARI ══
    '6ab' => ['baslik' => 'Doktora, doktoraya eşdeğer uzmanlık ya da sanatta yeterlik tezinde asıl danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 10],
    '6ab-es' => ['baslik' => 'Doktora, doktoraya eşdeğer uzmanlık ya da sanatta yeterlik tezinde ikinci/eş danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 5],
    '6c' => ['baslik' => 'Tezli yüksek lisans tezinde asıl danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 6],
    '6c-es' => ['baslik' => 'Tezli yüksek lisans tezinde ikinci/eş danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 3],

    // ══ 7. BİLİMSEL ARAŞTIRMA PROJELERİ ══
    '7a-y' => ['baslik' => 'AB Çerçeve Programı Ar-Ge projesinde koordinatör ya da yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['yurutucu'], 'puan' => 50],
    '7a-a' => ['baslik' => 'AB Çerçeve Programı Ar-Ge projesinde araştırmacı ya da uzman', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci'], 'puan' => 40],
    '7a-d' => ['baslik' => 'AB Çerçeve Programı Ar-Ge projesinde danışman', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['danisman'], 'puan' => 20],
    '7c-y' => ['baslik' => 'Diğer uluslararası kuruluşlarca desteklenen Ar-Ge projesinde koordinatör ya da yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 50],
    '7c-a' => ['baslik' => 'Diğer uluslararası kuruluşlarca desteklenen Ar-Ge projesinde araştırmacı ya da uzman', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['arastirmaci'], 'puan' => 30],
    '7c-d' => ['baslik' => 'Diğer uluslararası kuruluşlarca desteklenen Ar-Ge projesinde danışman', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['danisman'], 'puan' => 15],
    '7e-y' => ['baslik' => 'TÜBİTAK projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK'], 'roller' => ['yurutucu'], 'puan' => 25],
    '7e-a' => ['baslik' => 'TÜBİTAK projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK'], 'roller' => ['arastirmaci'], 'puan' => 30],
    '7e-d' => ['baslik' => 'TÜBİTAK projesinde danışman', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK'], 'roller' => ['danisman'], 'puan' => 10],
    '7f-y' => ['baslik' => 'TÜSEB projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['TÜSEB'], 'roller' => ['yurutucu'], 'puan' => 40],
    '7f-a' => ['baslik' => 'TÜSEB projesinde araştırmacı ya da danışman', 'kategori' => 'proje', 'kaynaklar' => ['TÜSEB'], 'roller' => ['arastirmaci', 'danisman'], 'puan' => 30],
    '7h-y' => ['baslik' => 'TÜBİTAK dışındaki kamu kurumlarıyla ya da özel kuruluşlarla yapılan projede yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 15],
    '7h-a' => ['baslik' => 'TÜBİTAK dışındaki kamu kurumlarıyla ya da özel kuruluşlarla yapılan projede araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['arastirmaci', 'danisman'], 'puan' => 10],
    '7ı-y' => ['baslik' => 'Üniversite Bilimsel Araştırma Projesinde (BAP) yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['yurutucu'], 'puan' => 15],
    '7ı-a' => ['baslik' => 'Üniversite Bilimsel Araştırma Projesinde (BAP) araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['arastirmaci', 'danisman'], 'puan' => 10],
    '7kl' => ['baslik' => 'Desteklenen bilimsel araştırma projesinde bursiyer olmak', 'kategori' => 'proje', 'kaynaklar' => ['Öğrenci Projesi (2209 vb.)'], 'puan' => 10],
    '7m' => ['baslik' => 'Üniversite-toplum ya da üniversite-sanayi iş birliği çerçevesinde sosyal sorumluluk projesinde görev almak', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Topluma Hizmet Projesi', 'Bilim İletişimi / Popüler Yayın'], 'puan' => 6],

    // ══ 8. BİLİMSEL TOPLANTILAR ══
    '8a' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulmuş ve CPCI\'da taranan bildiri kitapçığında tam metni yayımlanmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)'], 'puan' => 8],
    '8b' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulmuş ve CPCI\'da taranan bildiri kitapçığında özeti yayımlanmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Özet/Poster'], 'puan' => 4],
    '8c' => ['baslik' => 'Diğer bilimsel toplantılarda sunulmuş ve tam metni yayımlanmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin', 'Ulusal Tam Metin'], 'puan' => 6],
    '8ç' => ['baslik' => 'Diğer bilimsel toplantılarda sunulmuş ve özeti yayımlanmış bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Özet/Poster'], 'puan' => 3],
    '8de' => ['baslik' => 'Bilimsel toplantıda davetli konuşmacı olarak yer almak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 6],
    '8f' => ['baslik' => 'Sempozyum, kongre, konferans, çalıştay ya da festival başkanlığı veya düzenleme kurulu üyeliği', 'kategori' => 'diger', 'kaynaklar' => ['Diğer', 'Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)', 'Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'], 'puan' => 5],

    // ══ 9. İLETİŞİM, SANAT VE SPOR FAALİYETLERİ ══
    '9a' => ['baslik' => 'Uluslararası bireysel sanat etkinliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatKisiselU, 'puan' => 25],
    '9b' => ['baslik' => 'Uluslararası karma sanat etkinliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatKarmaU, 'puan' => 15],
    '9c' => ['baslik' => 'Ulusal bireysel sanat etkinliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatKisiselN, 'puan' => 15],
    '9ç' => ['baslik' => 'Ulusal karma sanat etkinliği', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatKarmaN, 'puan' => 8],
    '9ef' => ['baslik' => 'Yayımlanmış stüdyo, konser ya da görsel yapımın kayıt, mix ve mastering çalışması veya ses tasarımı', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatKayit, 'puan' => 8],
    '9g' => ['baslik' => 'Uluslararası yazılı, işitsel ve görsel basında yayın yapmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatHaberU, 'puan' => 15],
    '9ğ' => ['baslik' => 'Ulusal ve yerel yazılı, işitsel ve görsel basında yayın yapmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatHaberN, 'puan' => 8],
    '9hı' => ['baslik' => 'Yazılı, işitsel ve görsel basında yayın yönetmenliği, görsel yönetmenlik ya da editörlük', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatYonetmen, 'puan' => 10],
    '9k' => ['baslik' => 'Uluslararası etkinlikte film gösterimi yapmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatFilmU, 'puan' => 25],
    '9l' => ['baslik' => 'Ulusal etkinlikte film gösterimi yapmak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatFilmN, 'puan' => 15],
    '9m' => ['baslik' => 'Uluslararası etkinlikte film, dizi bölümü ya da televizyon programı yayımlamak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatYapimU, 'puan' => 30],
    '9n' => ['baslik' => 'Ulusal etkinlikte film, dizi bölümü ya da televizyon programı yayımlamak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatYapimN, 'puan' => 15],
    '9pr' => ['baslik' => 'Etkinliklerde jüri üyesi, yürütücü, koordinatör ya da danışman olarak görev almak', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatJuri, 'puan' => 5],
    '9-diger' => ['baslik' => 'Diğer sanat etkinlikleri', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanatKalan, 'puan' => 8],

    // ══ 10. PATENT, FAYDALI MODEL, TASARIM VE GİRİŞİMCİLİK ══
    '10a' => ['baslik' => 'Uluslararası tescillenmiş patent sahibi olmak', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 40],
    '10c' => ['baslik' => 'Ulusal tescillenmiş patent sahibi olmak', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 20],
    '10d' => ['baslik' => 'Tescillenmiş faydalı model sahibi olmak', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model'], 'puan' => 20],
    '10f' => ['baslik' => 'Tescillenmiş tasarım ya da yazılım sahibi olmak', 'kategori' => 'patent', 'kaynaklar' => ['Endüstriyel Tasarım', 'Yazılım', 'Islahçı Hakkı / Çeşit Tescili'], 'puan' => 16],
    '10ğ' => ['baslik' => 'Sahibi olduğunuz patent, faydalı model ya da tasarımı ticarileştirmek', 'kategori' => 'patent', 'kaynaklar' => ['Ticarileştirme'], 'puan' => 50],
    '10i' => ['baslik' => 'Sektörde, teknoparkta ya da sanayi Ar-Ge biriminde en az bir yıl danışmanlık veya mentörlük', 'kategori' => 'toplumsal_katki', 'kaynaklar' => ['Kamu/STK Danışmanlığı'], 'puan' => 6],

    // ══ 11. EĞİTİM-ÖĞRETİM VE İDARÎ FAALİYETLER ══
    '11a' => ['baslik' => 'Ön lisans, lisans ya da lisansüstü seviyede ders vermek', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders', 'Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 5],
    '11b' => ['baslik' => 'Lisansüstü tez jüri üyeliği yapmak', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Tez İzleme / Jüri Üyeliği'], 'puan' => 5],
    '11e' => ['baslik' => 'Akademik birim yöneticiliği yapmak', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Rektör', 'Rektör Yardımcısı', 'Dekan / Enstitü-YO Müdürü', 'Uygulama ve Araştırma Merkezi Müdürü', 'Bölüm Başkanı'], 'puan' => 16],
    '11f' => ['baslik' => 'Akademik birim yönetici yardımcılığı yapmak', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Dekan Yrd. / Müdür Yrd.', 'Bölüm Başkan Yardımcısı'], 'puan' => 12],
    '11g' => ['baslik' => 'Akademik komisyon, koordinatörlük, kurul ya da etik kurul üyeliği yapmak', 'kategori' => 'idari_gorev', 'kaynaklar' => ['Anabilim Dalı Başkanı / Koordinatörlük', 'Kurul / Komisyon Üyeliği', 'Senato / Üniversite Yönetim Kurulu Üyesi'], 'puan' => 8],
    '11h' => ['baslik' => 'Kurumsal akreditasyon çalışmalarında görev almak', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Akreditasyon Faaliyeti'], 'puan' => 4],

    // ══ 12. ARAŞTIRMA BURSLARI VE ÖDÜLLER ══
    '12abc' => ['baslik' => 'En az altı ay süreli araştırma bursu almak', 'kategori' => 'odul', 'kaynaklar' => ['Burs'], 'puan' => 20],
    '12ç' => ['baslik' => 'Uluslararası kurum ya da kuruluşlarca verilen bilim, teşvik, sanat veya hizmet ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Uluslararası Bilim/Sanat Ödülü', 'Ufuk Avrupa / ERC Ödülü'], 'puan' => 50],
    '12d' => ['baslik' => 'Ulusal kurum ya da kuruluşlarca verilen bilim, teşvik, sanat veya hizmet ödülü', 'kategori' => 'odul', 'kaynaklar' => ['Ulusal Bilim/Sanat Ödülü', 'TÜBİTAK / TÜBA Ödülü', 'TÜBA GEBİP / TWAS Teşvik Ödülü', 'YÖK Ödülü'], 'puan' => 40],
    '12fg' => ['baslik' => 'Alanınızla ilgili hakemli yarışmadan ödül kazanmak', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon'], 'puan' => 5],

    // ══ 13. DERGİ EDİTÖRLÜĞÜ, YAYIN KURULU ÜYELİĞİ VE HAKEMLİKLER ══
    '13a' => ['baslik' => 'SCI-E, SSCI veya AHCI kapsamındaki dergide editörlük ya da alan editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 15],
    '13b' => ['baslik' => 'Bilimsel hakemli dergide yayın kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 5],
    '13c' => ['baslik' => 'ESCI veya Scopus kapsamındaki dergide editörlük ya da alan editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi'], 'puan' => 10],
    '13ğ' => ['baslik' => 'ULAKBİM TR Dizin tarafından taranan dergide editörlük ya da alan editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi'], 'puan' => 10],
    '13ı' => ['baslik' => 'Diğer bilimsel hakemli dergilerde editörlük ya da alan editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Diğer Hakemli Dergi'], 'puan' => 6],
    '13j' => ['baslik' => 'Bilimsel hakemli dergilerde hakemlik', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 4],
];

$bolum = fn (string $onek): array => array_values(array_filter(
    array_keys($maddeler),
    fn (string $k) => $k === $onek || str_starts_with($k, $onek.'-')
        || (str_starts_with($k, $onek) && ! ctype_digit(substr($k, strlen($onek), 1))),
));

$b = [];
foreach (['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13'] as $n) {
    $b[$n] = array_values(array_filter(
        array_keys($maddeler),
        fn (string $k) => preg_match('/^'.$n.'(?![0-9])/u', $k) === 1,
    ));
}

$gruplar = $b;
$gruplar['1-8'] = array_merge($b['1'], $b['2'], $b['3'], $b['4'], $b['5'], $b['6'], $b['7'], $b['8']);
$gruplar['1-9'] = array_merge($gruplar['1-8'], $b['9']);
$gruplar['1-13'] = array_merge($gruplar['1-9'], $b['10'], $b['11'], $b['12'], $b['13']);

// Koşulların andığı bent kümeleri.
$gruplar['1a'] = ['1a-Q1', '1a-Q2', '1a-Q3', '1a-Q4'];
$gruplar['1a-Q123'] = ['1a-Q1', '1a-Q2', '1a-Q3'];
$gruplar['1bc'] = ['1b', '1c'];
$gruplar['1abc'] = ['1a-Q1', '1a-Q2', '1a-Q3', '1a-Q4', '1b', '1c'];
$gruplar['1abcç'] = ['1a-Q1', '1a-Q2', '1a-Q3', '1a-Q4', '1b', '1c', '1ç'];
$gruplar['1bcçd'] = ['1b', '1c', '1ç', '1d'];
$gruplar['2a'] = ['2a'];
$gruplar['2ab'] = ['2a', '2b'];
$gruplar['3a'] = ['3a'];
$gruplar['3bcg'] = ['3c', '3g'];
$gruplar['3abcg'] = ['3a', '3c', '3g'];
$gruplar['3bcçgğ'] = ['3c', '3g', '3ğ'];
$gruplar['3abcçgğ'] = ['3a', '3c', '3g', '3ğ'];
$gruplar['1a-3a'] = ['1a-Q1', '1a-Q2', '1a-Q3', '1a-Q4', '3a'];
$gruplar['7-P'] = ['7a-y', '7a-a', '7a-d', '7c-y', '7c-a', '7c-d', '7e-y', '7e-a', '7e-d',
    '7f-y', '7f-a', '7ı-y', '7ı-a'];
$gruplar['7-PH'] = array_merge($gruplar['7-P'], ['7h-y', '7h-a']);
$gruplar['7-PY'] = ['7a-y', '7a-a', '7a-d', '7c-y', '7c-a', '7c-d', '7h-y', '7h-a',
    '7e-y', '7e-a', '7e-d', '7ı-y', '7ı-a'];

// Proje koşulları "koordinatör/yürütücü/araştırmacı olmak VEYA iki projede
// DANIŞMANLIK yapmak" diyor; rol ayrımı satırlara gömülü olduğu için iki
// ayrı küme tanımlandı.
$gruplar['7-P-YA'] = ['7a-y', '7a-a', '7c-y', '7c-a', '7e-y', '7e-a', '7f-y', '7f-a', '7ı-y', '7ı-a'];
$gruplar['7-P-D'] = ['7a-d', '7c-d', '7e-d'];
$gruplar['7-PH-YA'] = array_merge($gruplar['7-P-YA'], ['7h-y', '7h-a']);
$gruplar['7-PY-YA'] = ['7a-y', '7a-a', '7c-y', '7c-a', '7e-y', '7e-a', '7h-y', '7h-a', '7ı-y', '7ı-a'];
$gruplar['7-PY-D'] = ['7a-d', '7c-d', '7e-d'];

// Kadro koşullarının andığı bent birleşimleri.
$gruplar['1bc-2a-3bcg'] = ['1b', '1c', '2a', '3c', '3g'];
$gruplar['1abc-2a-3abcg'] = ['1a-Q1', '1a-Q2', '1a-Q3', '1a-Q4', '1b', '1c', '2a', '3a', '3c', '3g'];
$gruplar['1bcçd-2ab'] = ['1b', '1c', '1ç', '1d', '2a', '2b'];
$gruplar['1bcçd-2ab-3bcçgğ'] = ['1b', '1c', '1ç', '1d', '2a', '2b', '3c', '3g', '3ğ'];
$gruplar['1abcç-2ab-3abcçgğ'] = ['1a-Q1', '1a-Q2', '1a-Q3', '1a-Q4', '1b', '1c', '1ç',
    '2a', '2b', '3a', '3c', '3g', '3ğ'];

return [
    'kapsam_notu' => 'Puanlar Kastamonu Üniversitesi Öğretim Üyeliğine Yükseltilme ve Atanma '
        .'Esasları Yönergesi EK-17 Puanlama Cetvelinden. Yazar çarpanı "Yazar/Eser Sahibi '
        .'Sıralamasına Göre Puanlama Tablosu"na göre işliyor (tek isimli %100; iki isimlide '
        .'%100/%90; üç isimlide %90/%80/%70; on dört ve üzeri isimde ilk isim %35, kalanlar %25). '
        .'Yazar listesini boş bırakırsanız çarpan hiç uygulanmaz ve puanınız olduğundan YÜKSEK '
        .'görünür. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: idari görevler ve dergi editörlükleri '
        .'yönergede "yıl başına" verildiği hâlde yıl biriktirmesi hesaplanamadığı için görev '
        .'başına tek yıl sayılıyor; 9. bölümün bütün sanat satırları "fiziki mekânda / çevrim içi" '
        .'diye çift puanlı ve kayıt bu ayrımı taşımadığı için hepsi çevrim içi (düşük) değerinden '
        .'sayılıyor; tezinizden üretilmiş SCI makalenizin çeyrekliği kayıtta olmadığı için en '
        .'düşük çeyreklikten (24 puan) sayılıyor; araştırma bursları, yarışma ödülleri, TÜBİTAK '
        .'proje yürütücülüğü ve dergi hakemliği en düşük satırdan sayılıyor. Kastamonu '
        .'Üniversitesi Yayınevi ve KÜ dergileri satırları, antrenörlük, spor hakemliği, reklam '
        .'kampanyaları, marka tescili ve laboratuvar kurma kalemleri sözlükte karşılıksız olduğu '
        .'için girilemedi. '
        .'Patent, faydalı model ve proje BAŞVURULARINIZI kaydetmeyin: yönerge onlara ayrı ve düşük '
        .'puan veriyor ama kayıt türü tescilliden ayrılamadığı için o satırlar girilmedi. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN YÜKSEK görünebilir: "aynı kitapta en fazla iki bölüm", '
        .'"aynı yıl en fazla N faaliyet" ve "aynı proje bir defa" gibi eser ve yıl bazlı sınırlar '
        .'uygulanmıyor; yönerge "patentlerde puan kişi sayısına bölünür" derken yazar tablosu '
        .'sıraya bağlı olduğu için çok buluşçulu patentin puanı bölünmüyor.',

    'yazar_katsayisi' => [
        'haric' => ['atif', 'tez_danismanligi', 'egitim_ogretim', 'idari_gorev',
            'odul', 'editorluk', 'toplumsal_katki', 'proje', 'diger'],
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.00]],
            'ilk' => ['kademeler' => [1 => 1.00, 2 => 1.00, 3 => 0.90, 4 => 0.85, 5 => 0.80,
                6 => 0.75, 7 => 0.70, 8 => 0.65, 9 => 0.60, 10 => 0.55, 11 => 0.50, 12 => 0.45,
                13 => 0.40], 'sonrasi' => 0.35],
            'baslica' => ['kademeler' => [1 => 1.00, 2 => 1.00, 3 => 0.90, 4 => 0.85, 5 => 0.80,
                6 => 0.75, 7 => 0.70, 8 => 0.65, 9 => 0.60, 10 => 0.55, 11 => 0.50, 12 => 0.45,
                13 => 0.40], 'sonrasi' => 0.35],
            'yazar_2' => ['kademeler' => [2 => 0.90, 3 => 0.80, 4 => 0.75, 5 => 0.70, 6 => 0.65,
                7 => 0.60, 8 => 0.55, 9 => 0.50, 10 => 0.45, 11 => 0.40, 12 => 0.35, 13 => 0.30],
                'sonrasi' => 0.25],
            'yazar_3' => ['kademeler' => [3 => 0.70, 4 => 0.65, 5 => 0.60, 6 => 0.55, 7 => 0.50,
                8 => 0.45, 9 => 0.40, 10 => 0.35, 11 => 0.30], 'sonrasi' => 0.25],
            'yazar_4' => ['kademeler' => [4 => 0.55, 5 => 0.50, 6 => 0.45, 7 => 0.40, 8 => 0.35,
                9 => 0.30], 'sonrasi' => 0.25],
            'yazar_5' => ['kademeler' => [5 => 0.40, 6 => 0.35, 7 => 0.30], 'sonrasi' => 0.25],
            'yazar_6' => ['sonrasi' => 0.25],
            'ortak' => ['kademeler' => [1 => 1.00, 2 => 0.90, 3 => 0.70, 4 => 0.55, 5 => 0.40,
                6 => 0.25], 'sonrasi' => 0.25],
        ],
    ],

    'maddeler' => $maddeler,
    'gruplar' => $gruplar,
    'grup_tavanlari' => [],
];
