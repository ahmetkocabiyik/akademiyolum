<?php

use App\Enums\Kategori;

/**
 * İSTANBUL MEDENİYET ÜNİVERSİTESİ — Yönerge Eki: Puanlama Tablosu
 * Kaynak: pdf/17536997062.istanbulmedeniyetuniverstesi.pdf (7 sayfa;
 * PDF oluşturma tarihi 06.12.2018)
 *
 * MADDE KODLARI YÖNERGENİN KENDİSİ: tablo 13 numaralı bölüme, bölümler de
 * a-h harflerine ayrılıyor (`1a`, `3g`, `4h`). Koşullar bölüm numarasıyla
 * atıf yapıyor ("Puanlama Tablosunun 1. 2. ve 4. Bölümlerinden"), bu yüzden
 * numaralar `gruplar` altında birebir tanımlandı. Tek haneli numaralar
 * yüzünden desenlerde yıldız KULLANILMADI (`'1*'` deseni 10-13. bölümleri
 * de yakalardı); her grup kodları tek tek sayıyor.
 *
 * Bize ait olan tek şey tek kayda düşen satırların tire ile yazılmış çift
 * kodları (`5a-5b`, `10a-10d`) ve eş danışmanlık için açılan `-es` ekleri.
 *
 * ── AYNI KAYNAĞA DÜŞÜP DÜŞÜĞÜ GİRİLEN SATIRLAR ──
 *   5a (uluslararası ansiklopedi maddesi 10) ile 5b (ulusal 5): tek
 *       'Ansiklopedi Maddesi' etiketi → 5.
 *   10a (uluslararası davetli konuşmacı 7) ile 10d (ulusal 2): tek
 *       'Davetli Konuşmacı' etiketi → 2.
 *   13'ün dergi editörlüğü (15/10), editör yardımcılığı (7/5) ve konuk
 *       editörlük (5/3) satırları: kayıt editörlük düzeyini ayırmıyor →
 *       uluslararası indeksli dergilerde 5, diğerlerinde 3.
 *   13'ün hakemlik satırları (uluslararası 2, ulusal 1) → 1.
 *   12'nin sanatsal faaliyet satırlarında uluslararası/ulusal ve
 *       bireysel/karma ayrımı taşımayan etiketler (koreografi, sahne
 *       tasarımı, özgün beste, orkestra üyeliği gibi) EN DÜŞÜK satıra
 *       (12d, 5 puan) bağlandı; bölüm sonundaki `array_diff` bunu
 *       kendiliğinden yapıyor ve sözlüğe yeni bir sanat etiketi
 *       eklendiğinde de en düşük satıra düşmesini garantiliyor.
 *
 * ── "TEK YAZAR" KAYDI SATIRIN KENDİSİNDE ──
 * 4a (uluslararası kitap yazarlığı 30) ve 4g (kitap çeviri yazarlığı 5)
 * yönergede AÇIKÇA "(Tek yazar)" diyor; iki satır da `roller => ['tek']`
 * taşıyor. Kitabınızı tek yazar olarak kaydetmezseniz bu satırlardan puan
 * ALAMAZSINIZ — çok yazarlı uluslararası kitap yönergede puansız.
 *
 * ── GİRİLMEYEN KALEMLER ──
 *   Poster ve özet bildiriler — 10. bölüm yalnızca "sunulan ve bildiri
 *       kitabında basılan SÖZLÜ bildiri" satırlarını taşıyor.
 *   Diğer uluslararası destekli projelerde ARAŞTIRMACI olmak — 9c
 *       yalnızca yürütücüyü puanlıyor, araştırmacı satırı yok.
 *   Faydalı model, endüstriyel tasarım, yazılım, ıslahçı hakkı,
 *       ticarileştirme — 6. bölüm yalnızca patent diyor.
 *   Tez izleme komitesi ve jüri üyeliği, akreditasyon faaliyeti,
 *       toplumsal katkı ve idari görev — tabloda karşılık gelen satır YOK.
 *       İdari görevi olan adayın puanı bu yüzden olduğundan düşük değil,
 *       yönergede gerçekten puansız.
 *   Tezden üretilmiş BİLDİRİ — 3. bölüm yalnızca kitap ve makale
 *       satırları taşıyor.
 *
 * ── MOTORUN KARŞILAYAMADIĞI KURAL ──
 * 6. bölümün dipnotu "Patentlerde puan kişi sayısına bölünür" diyor, ama
 * yönergenin genel katkı oranı tablosu SIRAYA bağlı (başlıca ve sorumlu
 * yazar daima %100). Cetvel başına tek katsayı matrisi tanımlanabildiği
 * için sıraya bağlı olan matris yazıldı: ÇOK BULUŞÇULU PATENTİNİZİN PUANI
 * OLDUĞUNDAN YÜKSEK görünür (en çok 20 puanlık bir sapma). Bu, §0'ın
 * "eksik say" kuralından bilinçli ve sınırlı bir sapmadır; alternatifi
 * bütün yayınlara 1/n uygulayıp adayın makale puanını olduğundan çok
 * düşük göstermekti. `kapsam_notu` adayı uyarıyor.
 *
 * Yönerge: yonerge/istanbul-medeniyet.php
 *
 * TANINMIŞ YAYINEVİ AYRIMI KAPSAM ETİKETİNE BAĞLANDI (19.09.2026): sıfat iki
 * kademede de aynı, ayrımı yapan tek şey yayınevinin kapsamı. Kapsamlı
 * etiketler üst satırlara bağlandı, ulusal satırlar daraltıldı.
 *
 * 4a yalnız TEK YAZARLI kitabı puanlıyor (`roller`); çok yazarlı uluslararası
 * kitabın kaynakta satırı yok, 4d'nin ulusal kademesinden sayılmayı sürdürüyor.
 */

// 12. bölümün uluslararası/ulusal ve bireysel/karma ayrımını taşıyan
// etiketleri. Listede olmayan her sanat etiketi 12d'ye (en düşük) düşer.
$sanat12a = [
    'Kişisel Etkinlik (Uluslararası)', 'Elektronik Kişisel Sergi (Uluslararası)',
    'Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)', 'Belgesel/Kısa Film (Uluslararası)',
    'Dansçı / Performans İcracısı (Uluslararası)', 'Solistlik (Uluslararası)',
    'Resital (Uluslararası)', 'Şan Resitali (Uluslararası)',
    'Opera Birinci Rol (Uluslararası)', 'Opera İkinci Rol (Uluslararası)',
    'Oratoryo/Kantat Solistliği (Uluslararası)', 'Bale Başrol (Uluslararası)',
    'Bale Solist Rol (Uluslararası)', 'Rejisörlük (Uluslararası)',
    'Orkestra Şefliği (Uluslararası)', 'Opera Şefliği (Uluslararası)',
    'Bale Orkestra Şefliği (Uluslararası)', 'Koro Şefliği (Uluslararası)',
    'Grup Şefliği (Uluslararası)', 'Başkemancılık (Uluslararası)',
];

$sanat12b = [
    'Karma/Jürili Etkinlik (Uluslararası)', 'Elektronik Karma Sergi (Uluslararası)',
    'Karma Etkinlik (Yurt İçi, Uluslararası Jürili)', 'Karma Etkinlik (Yurt Dışı, Ulusal Jürili)',
    'Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)', 'Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)',
    'Kişisel Etkinlik (Yurt Dışı, Jürisiz)', 'Oda Müziği Grup Üyeliği (Uluslararası)',
    'Corps de Ballet (Uluslararası)', 'Sahneleme/Repetitörlük — Tüm Perde (Uluslararası)',
    'Sahneleme/Repetitörlük — Bölüm (Uluslararası)', 'Bale/Dans Koreograflığı (Uluslararası)',
    'Tüm Perde Koreograflığı (Uluslararası)', 'Bölüm Koreograflığı (Uluslararası)',
    'Rejisör Yardımcılığı (Uluslararası)', 'Eğitici Konser Programı (Uluslararası)',
    'Masterclass (Uluslararası)', 'Jüri Başkanlığı (Uluslararası)', 'Jüri Üyeliği (Uluslararası)',
    'Sempozyum/Çalıştay/Bienal (Yurt Dışı)', 'Eserin Müzeye Kabulü (Yurt Dışı)',
    'Eserin Haber Olması (Uluslararası)', 'Koruma-Onarım Uygulaması (Uluslararası)',
];

$sanat12c = [
    'Kişisel Etkinlik (Ulusal)', 'Elektronik Kişisel Sergi (Ulusal)',
    'Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)', 'Belgesel/Kısa Film (Ulusal)',
    'Dansçı / Performans İcracısı (Ulusal)', 'Solistlik (Ulusal)',
    'Resital (Ulusal)', 'Şan Resitali (Ulusal)',
    'Opera Birinci Rol (Ulusal)', 'Opera İkinci Rol (Ulusal)',
    'Oratoryo/Kantat Solistliği (Ulusal)', 'Bale Başrol (Ulusal)',
    'Bale Solist Rol (Ulusal)', 'Rejisörlük (Ulusal)', 'Rejisörlük (Konservatuvar)',
    'Orkestra Şefliği (Ulusal)', 'Opera Şefliği (Ulusal)', 'Bale Orkestra Şefliği (Ulusal)',
    'Koro Şefliği (Ulusal)', 'Grup Şefliği (Ulusal)', 'Başkemancılık (Ulusal)',
    'Albüm / Konser Kaydı', 'Bandrollü Kayıt (CD/DVD)',
];

$sanat12d = array_values(array_diff(
    Kategori::SanatselEtkinlik->kaynaklar(),
    $sanat12a, $sanat12b, $sanat12c,
));

$maddeler = [
    // ══ 1. ULUSLARARASI MAKALE (tezden üretilmemiş) ══
    '1a' => ['baslik' => 'SSCI, SCI, SCI-Expanded veya AHCI kapsamındaki dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 20],
    '1b' => ['baslik' => 'Uluslararası alan endekslerinde taranan dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale', 'derleme'], 'puan' => 15],
    '1c' => ['baslik' => 'Uluslararası dergide yayımlanmış kitap kritiği ya da benzeri kısa yayın', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI', 'ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 5],

    // ══ 2. ULUSAL MAKALE (tezden üretilmemiş) ══
    '2a' => ['baslik' => 'ULAKBİM tarafından taranan ulusal hakemli dergide ya da İMÜ dergilerinde yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'puan' => 10],
    '2b' => ['baslik' => 'Diğer ulusal hakemli dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'puan' => 5],

    // ══ 3. LİSANSÜSTÜ VEYA UZMANLIK TEZLERİNDEN ÜRETİLMİŞ YAYIN ══
    '3a' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, tanınmış uluslararası yayınevi tarafından yayımlanmış kitap', 'kategori' => 'tez_yayini', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 10],
    '3b' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, tanınmış uluslararası yayınevi kitabında bölüm yazarlığı', 'kategori' => 'tez_yayini', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 8],
    '3c' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, tanınmış ulusal yayınevi tarafından yayımlanmış kitap', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 5],
    '3d' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, tanınmış ulusal yayınevi kitabında bölüm yazarlığı', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 4],
    '3e' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, SSCI, SCI, SCI-Expanded veya AHCI kapsamındaki dergide yayımlanmış makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['SCIE/SSCI/AHCI'], 'puan' => 8],
    '3f' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, uluslararası alan endekslerinde taranan dergide yayımlanmış makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['ESCI / Scopus'], 'puan' => 6],
    '3g' => ['baslik' => 'Lisansüstü tezinizden üretilmiş, ULAKBİM tarafından taranan dergide yayımlanmış makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['TR Dizin', 'Diğer'], 'puan' => 4],

    // ══ 4. KİTAP (tezden üretilmemiş) ══
    '4a' => ['baslik' => 'Tanınmış uluslararası yayınevi tarafından yayımlanmış kitap yazarlığı (tek yazar)', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap', 'Uluslararası Kitap'], 'roller' => ['tek'], 'puan' => 30],
    '4b' => ['baslik' => 'Tanınmış uluslararası yayınevi tarafından yayımlanmış kitabın editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap', 'Uluslararası Kitap Editörlüğü'], 'puan' => 15],
    '4c' => ['baslik' => 'Tanınmış uluslararası yayınevi kitabında bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü', 'Uluslararası Kitap Bölümü'], 'puan' => 10],
    '4d' => ['baslik' => 'Tanınmış ulusal yayınevi, İMÜ Yayınevi ya da resmi kurum tarafından yayımlanmış kitap yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ulusal Kitap', 'Tahkik (Tenkitli Metin)', 'Ders / Metot Kitabı'], 'puan' => 20],
    '4e' => ['baslik' => 'Tanınmış ulusal yayınevi, İMÜ Yayınevi ya da resmi kurum tarafından yayımlanmış kitabın editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü', 'Ulusal Kitap Editörlüğü'], 'puan' => 10],
    '4f' => ['baslik' => 'Tanınmış ulusal yayınevi, İMÜ Yayınevi ya da resmi kurum kitabında bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ulusal Kitap Bölümü'], 'puan' => 7],
    '4g' => ['baslik' => 'Kitap çeviri yazarlığı (tek yazar)', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap'], 'roller' => ['tek'], 'puan' => 5],
    '4h' => ['baslik' => 'Çeviri kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Çeviri Kitap Bölümü'], 'puan' => 3],

    // ══ 5. ANSİKLOPEDİ MADDESİ ══
    '5a-5b' => ['baslik' => 'Tanınmış ulusal ya da uluslararası yayınevi ansiklopedisinde madde yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Ansiklopedi Maddesi'], 'puan' => 5],

    // ══ 6. PATENT ══
    '6a' => ['baslik' => 'Uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 20],
    '6b' => ['baslik' => 'Ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 10],

    // ══ 7. ATIFLAR — en fazla 25 puan ══
    '7a' => ['baslik' => 'SCI, SCI-Expanded, SSCI, AHCI dergilerinde ya da tanınmış uluslararası yayınevi kitaplarında atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'BKCI Kitap'], 'puan' => 3],
    '7b' => ['baslik' => 'Bu indeksler dışındaki endeksli dergilerde ya da uluslararası yayınevi kitap bölümlerinde atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer (Uluslararası)'], 'puan' => 2],
    '7c' => ['baslik' => 'Ulusal hakemli dergilerde ya da tanınmış ulusal yayınevi kitaplarında atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Patent'], 'puan' => 1],

    // ══ 8. TEZ DANIŞMANLIĞI (tamamlanmış) — en fazla 10 puan ══
    '8a' => ['baslik' => 'Tamamlanmış doktora ya da uzmanlık tezinde asıl danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 5],
    '8a-es' => ['baslik' => 'Tamamlanmış doktora ya da uzmanlık tezinde ikinci/eş danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['es_danisman'], 'puan' => 2],
    '8b' => ['baslik' => 'Tamamlanmış yüksek lisans tezinde asıl danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 2],
    '8b-es' => ['baslik' => 'Tamamlanmış yüksek lisans tezinde ikinci/eş danışmanlık', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['es_danisman'], 'puan' => 1],

    // ══ 9. BİLİMSEL ARAŞTIRMA PROJESİ — en fazla 40 puan ══
    '9a' => ['baslik' => 'AB Çerçeve Programı bilimsel araştırma projesinde koordinatör ya da yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['yurutucu'], 'puan' => 40],
    '9b' => ['baslik' => 'AB Çerçeve Programı bilimsel araştırma projesinde ortak araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 15],
    '9c' => ['baslik' => 'Diğer uluslararası destekli bilimsel araştırma projesinde yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 15],
    '9d' => ['baslik' => 'Üniversiteler dışındaki kamu kurumlarıyla yapılan bilimsel araştırma projesinde yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 15],
    '9e' => ['baslik' => 'Üniversiteler dışındaki kamu kurumlarıyla yapılan bilimsel araştırma projesinde ortak araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 8],
    '9f' => ['baslik' => 'Üniversitelerde yürütülen bilimsel araştırma projesinde yürütücü olmak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['yurutucu'], 'puan' => 8],
    '9g' => ['baslik' => 'Üniversitelerde yürütülen bilimsel araştırma projesinde araştırmacı olmak', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)', 'Öğrenci Projesi (2209 vb.)'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 4],

    // ══ 10. BİLİMSEL TOPLANTI — en fazla 15 puan ══
    '10a-10d' => ['baslik' => 'Bilimsel toplantıda davetli konuşmacı olmak', 'kategori' => 'bildiri', 'kaynaklar' => ['Davetli Konuşmacı'], 'puan' => 2],
    '10b' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulan ve bildiri kitabında basılan sözlü bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 5],
    '10c' => ['baslik' => 'Ulusal bilimsel toplantıda sunulan ve bildiri kitabında basılan sözlü bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 2],

    // ══ 11. EĞİTİM-ÖĞRETİM FAALİYETİ — en fazla 10 puan ══
    '11a' => ['baslik' => 'Bir dönemde verilen lisansüstü ya da uzmanlık dersi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 3],
    '11b' => ['baslik' => 'Bir dönemde verilen ön lisans ya da lisans dersi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 1],

    // ══ 12. SANATSAL FAALİYETLER ══
    '12a' => ['baslik' => 'Uluslararası bireysel sanat etkinliği (sergi, bienal, workshop, film, tiyatro, dinleti, albüm, TV/radyo programı)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanat12a, 'puan' => 20],
    '12b' => ['baslik' => 'Uluslararası karma sanat etkinliği (sergi, konser, film, tiyatro, albüm, TV/radyo programı)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanat12b, 'puan' => 10],
    '12c' => ['baslik' => 'Ulusal bireysel sanat etkinliği (sergi, bienal, workshop, film, tiyatro, dinleti, albüm, TV/radyo programı)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanat12c, 'puan' => 10],
    '12d' => ['baslik' => 'Ulusal karma sanat etkinliği (sergi, konser, film, tiyatro, albüm, TV/radyo programı)', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => $sanat12d, 'puan' => 5],

    // ══ 13. DERGİ EDİTÖRLÜĞÜ, KURUL ÜYELİĞİ VE HAKEMLİK — en fazla 25 puan ══
    '13a-ed' => ['baslik' => 'SCI, SCIE, SSCI ya da AHCI indeksli dergide editörlük, editör yardımcılığı ya da konuk editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)'], 'puan' => 5],
    '13b-ed' => ['baslik' => 'Alan indeksli uluslararası ya da ULAKBİM tarafından taranan ulusal dergide editörlük, editör yardımcılığı ya da konuk editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['ESCI / Scopus Dergi', 'TR Dizin Dergi', 'Diğer Hakemli Dergi'], 'puan' => 3],
    '13-kurul' => ['baslik' => 'Dergi yayın ya da danışma kurulu üyeliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Yayın Kurulu Üyeliği'], 'puan' => 1],
    '13-hakemlik' => ['baslik' => 'Dergi hakemliği', 'kategori' => 'editorluk', 'kaynaklar' => ['Hakemlik'], 'puan' => 1],
];

// Tek haneli bölüm numaraları yüzünden yıldız deseni kullanılmadı.
$gruplar = [
    '1' => ['1a', '1b', '1c'],
    '2' => ['2a', '2b'],
    '3' => ['3a', '3b', '3c', '3d', '3e', '3f', '3g'],
    '4' => ['4a', '4b', '4c', '4d', '4e', '4f', '4g', '4h'],
    '5' => ['5a-5b'],
    '6' => ['6a', '6b'],
    '7' => ['7a', '7b', '7c'],
    '8' => ['8a', '8a-es', '8b', '8b-es'],
    '9' => ['9a', '9b', '9c', '9d', '9e', '9f', '9g'],
    '10' => ['10a-10d', '10b', '10c'],
    '11' => ['11a', '11b'],
    '12' => ['12a', '12b', '12c', '12d'],
    '13' => ['13a-ed', '13b-ed', '13-kurul', '13-hakemlik'],

    // MADDE 8(4): "Puanlama Tablosunun 1. 2. ve 4. Bölümlerinden".
    '1-2-4' => ['1', '2', '4'],

    // MADDE 8(1)'in dört akademik eser şartı.
    'SCI-MAKALE' => ['1a', '3e'],
    'ULUSLARARASI-MAKALE' => ['1a', '1b', '3e', '3f'],
    'KITAP-BOLUM' => ['4a', '4c', '4d', '4f', '3a', '3b', '3c', '3d'],
    'ULAKBIM-MAKALE' => ['2a', '3g'],
];

return [
    'kapsam_notu' => 'Puanlar İstanbul Medeniyet Üniversitesi Öğretim Üyeliğine Yükseltilme ve '
        .'Atanma Yönergesi ekindeki Puanlama Tablosundan. Yazar çarpanı yönergenin "Yayınlarda '
        .'kullanılacak katkı oranları" tablosuna göre işliyor: başlıca ya da sorumlu yazar tam '
        .'puan; iki yazarlıda 1. isim %80, 2. isim %70; üç yazarlıda %70/%60/%50; dört ve daha '
        .'fazla yazarlıda %60/%50/%40 ve dördüncüden sonrası %30. Yönergenin kendi içindeki '
        .'çelişki (Tanımlar bölümü ilk yazarı "başlıca yazar" sayıp %100 verirken katkı tablosu '
        .'birinci isme %80 veriyor) §0 uyarınca DÜŞÜK okundu: sorumlu yazar da sıraya göre '
        .'puanlanıyor, yani gerçekten sorumlu yazarsanız puanınız olduğundan DÜŞÜK görünür. '
        .'Yazar listesini boş bırakırsanız '
        .'çarpan hiç uygulanmaz ve puanınız olduğundan YÜKSEK görünür. '
        .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: davetli konuşmalarda uluslararası ile '
        .'ulusal ayrımı, dergi görevlerinde editör ile yardımcı ve konuk editör ayrımı, '
        .'ansiklopedi maddesinde uluslararası ile ulusal ayrımı kayıttan okunamadığı için hepsi en '
        .'düşük değerden sayılıyor. Uluslararası kitap yazarlığı (30 puan) ve kitap çevirisi '
        .'(5 puan) yönergede AÇIKÇA "tek yazar" diyor: kitabınızı tek yazar olarak kaydetmezseniz '
        .'bu satırlardan puan alamazsınız. Poster ve özet bildiriler, diğer uluslararası '
        .'projelerde araştırmacılık, faydalı model, endüstriyel tasarım, tez izleme komitesi '
        .'üyeliği, toplumsal katkı ve idari görev kalemlerine yönergenin tablosunda karşılık gelen '
        .'satır YOK; bunlar yönergede gerçekten puansız. '
        .'Puanınız şu kalemde OLDUĞUNDAN YÜKSEK görünebilir: yönerge "patentlerde puan kişi '
        .'sayısına bölünür" diyor ama genel katkı oranı tablosu sıraya bağlı olduğu için çok '
        .'buluşçulu patentinizin puanı bölünmüyor (en çok 20 puanlık sapma). Atıf puanı da '
        .'yönergede "adayın atıf yapılan her eseri için" veriliyor, kayıt ise atıf başına tutuluyor.',

    // "Yayınlarda kullanılacak katkı oranları tablosu" SIRAYA ve yazar
    // sayısına bağlı. Kaynak kendi içinde çelişiyor: (a) bendi "başlıca
    // yazar ile sorumlu yazar için birim puanın %100'ü" derken Tanımlar
    // bölümü başlıca yazarı "yazarlardan ilk sırada yer alan yazar" diye
    // tanımlıyor, (b)-(ç) bentleri ise birinci isme %80/%70/%60 veriyor.
    // §0 uyarınca DÜŞÜK okuma alındı: `baslica` rolü `ilk` ile aynı
    // satırları taşıyor. Gerçekten sorumlu yazar olan adayın puanı bu
    // yüzden olduğundan düşük görünür.
    'yazar_katsayisi' => [
        'haric' => ['atif', 'proje', 'tez_danismanligi', 'egitim_ogretim',
            'idari_gorev', 'odul', 'editorluk', 'toplumsal_katki', 'sanatsal_etkinlik'],
        'roller' => [
            'tek' => ['kademeler' => [1 => 1.0]],
            'baslica' => ['kademeler' => [1 => 1.00, 2 => 0.80, 3 => 0.70], 'sonrasi' => 0.60],
            'ilk' => ['kademeler' => [1 => 1.00, 2 => 0.80, 3 => 0.70], 'sonrasi' => 0.60],
            'yazar_2' => ['kademeler' => [2 => 0.70, 3 => 0.60], 'sonrasi' => 0.50],
            'yazar_3' => ['kademeler' => [3 => 0.50], 'sonrasi' => 0.40],
            'yazar_4' => ['sonrasi' => 0.30],
            'yazar_5' => ['sonrasi' => 0.30],
            'yazar_6' => ['sonrasi' => 0.30],
            'ortak' => ['kademeler' => [1 => 1.00, 2 => 0.70, 3 => 0.50], 'sonrasi' => 0.30],
        ],
    ],

    'maddeler' => $maddeler,
    'gruplar' => $gruplar,

    'grup_tavanlari' => [
        '7' => 25,
        '8' => 10,
        '9' => 40,
        '10' => 15,
        '11' => 10,
        '13' => 25,
    ],
];
