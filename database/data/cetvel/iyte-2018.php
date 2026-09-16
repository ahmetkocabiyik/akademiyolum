<?php

/**
 * İZMİR YÜKSEK TEKNOLOJİ ENSTİTÜSÜ — Ek-1, Ek-2 ve Ek-3 puanlama sistemleri
 * Kaynak: pdf/17536998302.izmiryuksekteknolojiuniverstesi.pdf
 * (Senato 25.07.2017-14/3; 17.04.2018-9/4 ve 15.05.2018-10/9 kararlarıyla
 * değişik)
 *
 * ── ÜÇ TEMEL ALAN, ÜÇ AYRI EK ──
 *   iyte-2018-e1-*  → Ek-1 Fen ve Mühendislik Temel Alan (`fen`, `muhendislik`)
 *   iyte-2018-e2-*  → Ek-2 Mimarlık, Planlama ve Tasarım Temel Alan (`mimarlik`)
 *   iyte-2018-e3    → Ek-3 Eğitim Bilimleri Temel Alanı (`egitim`)
 *
 * MADDE KODLARI YÖNERGENİN KENDİSİ (1a-9b); ek numarası öne eklendi
 * (`E1-1a`, `E2-4c`, `E3-8c`) çünkü üç tablo tek dosyada duruyor ve madde
 * numaraları çakışıyor. Bize ait olan tek şey tek kayda düşen satırların
 * tire ile yazılmış çift kodları (`E1-2c-2d`, `E1-3b-ed`).
 *
 * ── EK-1 VE EK-2'NİN EĞİTİM TAVANI KADROYA BAĞLI → KADRO VARYANTI ──
 * Her iki ekin 9. maddesi "Doçentlik için en çok 6 puan ve Profesörlük için
 * en çok 10 puan" diyor; Dr. Öğretim Üyeliğinde tavan yok. Bu yüzden Ek-1
 * ve Ek-2 üç kadro varyantında üretildi. Ek-3'te böyle bir tavan yok, tek
 * varyant.
 *
 * ── AYNI KAYNAĞA DÜŞÜP DÜŞÜĞÜ GİRİLEN SATIRLAR ──
 *   2(c) uluslararası tez bildirisi (5) ile 2(d) ulusal (3): `tez_yayini`
 *       sözlüğünde tek 'CPCI Bildiri' etiketi → 3.
 *   Ek-2 4(a) yarışma derecesi 15 puan ama dipnotu "ekip başı tam puanın
 *       0,8'ini, diğerleri 0,5'ini alır" diyor; `odul` kategorisinde rol
 *       ayrımı olmadığı için en düşük pay alındı: 15 × 0,5 = 7,5 → 7.
 *   Ek-3 1(a) "Eğitim Bilimleri Temel Alanı endeksleri" ile 1(b) "Yabancı
 *       Dil Eğitimi alan endeksleri" aynı 'ESCI / Scopus' etiketine
 *       düşüyor → 15 (düşük olan).
 *   Ek-3'te 'Diğer Uluslararası İndeks' etiketine karşılık gelen satır yok;
 *       §0 uyarınca en düşük ulusal satıra (1e, 4 puan) bağlandı.
 *
 * ── GİRİLMEYEN KALEMLER ──
 *   Ek-1 ve Ek-2'nin 1. maddesi derlemeyi, editöre mektubu, teknik notu ve
 *       kitap kritiğini AÇIKÇA dışlıyor; bu türlere hiç satır yazılmadı.
 *       Derlemeniz bu üniversitede puansız.
 *   Ek-1'de 'Diğer Ulusal Hakemli' dergi satırı YOK (yalnızca ULAKBİM
 *       taranan ulusal dergiler puanlanıyor).
 *   7. maddede yalnızca AB projelerinde araştırmacılık puanlanıyor; diğer
 *       uluslararası ve kamu projelerinde YALNIZCA yürütücülük satırı var,
 *       araştırmacılık ve BAP projeleri hiç puanlanmıyor.
 *   8. maddede yalnızca tam metni basılmış SÖZLÜ bildiri var; poster, özet
 *       ve davetli konuşmacılık satırı yok.
 *   Editörlük ve hakemlik (dergi), idari görev, ödül, toplumsal katkı ve
 *       sanatsal etkinlik kalemlerine üç ekin hiçbirinde satır YOK; bunlar
 *       yönergede gerçekten puansız.
 *   Eş danışmanlık, tez izleme komitesi üyeliği, ansiklopedi maddesi ve
 *       çeviri kitap — karşılık gelen satır yok.
 *
 * ── MOTORUN KARŞILAYAMADIĞI KURALLAR ──
 *   Madde 6: yabancı uyruklu öğretim üyelerinden minimum ölçütlerin İKİ
 *       KATI isteniyor; uyruk profilde yok, tek katı uygulanıyor.
 *   Ek-2 4(a)'nın ekip başı/diğer ayrımı ve 4. maddenin "en az 15 puan"
 *       dipnotu; ikincisi koşul olarak yönergeye yazıldı.
 *
 * Yönerge: yonerge/iyte.php
 *
 * KODLAR BİZE AİT — KAYNAKTA SATIR KODU YOK. Cetvel kodlarının SAYISAL
 * ÇEKİRDEĞİ kaynağın madde/bölüm numarasıdır; baştaki harf tabloyu ya da
 * eki, sondaki harf şıkkı gösterir ve ikisi de bizim eklediğimiz parçadır.
 * Koşullar bu kodlara atıf yaptığı için değiştirilmemeli; kaynakla
 * karşılaştırırken kodun sayısal çekirdeğine bakılmalı.
 */
$SCI = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)', 'AHCI'];

// "Tek yazarlı çalışmalarda yazar tam puan alır. Başlıca yazarın belirtildiği
// hallerde iki yazarlı eserlerde başlıca yazar 0,8'ini, ikinci yazar 0,5'ini
// alır. Üç ve daha fazla yazarlı başlıca yazarın belirtildiği eserlerde
// başlıca yazar toplam puanın yarısını alır, diğer yazarlar diğer yarısını
// eşit paylaşır. Başlıca yazarın belirtilmediği eserlerde puan yazar sayısına
// bölünür." Başlıca yazarın BELİRTİLMEDİĞİ hâl 1/n olduğu için, sıra
// belirtmeyen roller o kuralı alır.
$yazarKatsayisi = [
    'haric' => ['atif', 'tez_danismanligi', 'egitim_ogretim', 'idari_gorev',
        'odul', 'editorluk', 'toplumsal_katki', 'proje'],
    'roller' => [
        'tek' => ['kademeler' => [1 => 1.0]],
        // Başlıca yazar: iki yazarlıda 0,80; üç ve daha fazlada tam puanın yarısı.
        'baslica' => ['kademeler' => [1 => 1.00, 2 => 0.80], 'sonrasi' => 0.50],
        'ilk' => ['kademeler' => [1 => 1.00, 2 => 0.80], 'sonrasi' => 0.50],
        // Diğer yazarlar kalan yarıyı eşit paylaşır: 0,5 / (n − 1).
        'yazar_2' => ['kademeler' => [2 => 0.50], 'bol' => ['pay' => 0.5, 'eksi' => 1]],
        'yazar_3' => ['bol' => ['pay' => 0.5, 'eksi' => 1]],
        'yazar_4' => ['bol' => ['pay' => 0.5, 'eksi' => 1]],
        'yazar_5' => ['bol' => ['pay' => 0.5, 'eksi' => 1]],
        'yazar_6' => ['bol' => ['pay' => 0.5, 'eksi' => 1]],
        // Başlıca yazarın belirtilmediği hâl: puan yazar sayısına bölünür.
        'ortak' => ['sonrasi_pay' => 1.0],
    ],
];

/**
 * Ek-1 ve Ek-2 aynı iskeleti paylaşıyor; ayrıştıkları noktalar parametre.
 *
 * @param  list<string>  $birATarama  1(a) ve 2(a)'nın kapsadığı indeksler
 * @param  array<string, array<string, mixed>>  $dortuncuMadde  4. madde satırları
 * @return array<string, array<string, mixed>>
 */
$ekGovdesi = function (array $birATarama, array $birBTarama, array $ikiATarama, array $dortuncuMadde, string $on): array {
    return [
        "{$on}-1a" => ['baslik' => 'Uluslararası hakemli dergide yayımlanmış özgün tam araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => $birATarama, 'turler' => ['ozgun_makale'], 'puan' => 20],
        "{$on}-1b" => ['baslik' => 'Diğer uluslararası hakemli dergide yayımlanmış özgün tam araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => $birBTarama, 'turler' => ['ozgun_makale'], 'puan' => 8],
        "{$on}-1c" => ['baslik' => 'ULAKBİM tarafından taranan ulusal hakemli dergide yayımlanmış özgün tam araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale'], 'puan' => 8],

        "{$on}-2a" => ['baslik' => 'Lisansüstü tezinizle ilgili, uluslararası hakemli dergide yayımlanmış makale', 'kategori' => 'tez_yayini', 'kaynaklar' => $ikiATarama, 'puan' => 10],
        "{$on}-2b" => ['baslik' => 'Lisansüstü tezinizle ilgili, diğer uluslararası ya da ulusal hakemli dergide yayımlanmış makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Diğer', 'TR Dizin'], 'puan' => 5],
        "{$on}-2c-2d" => ['baslik' => 'Lisansüstü tezinizle ilgili, bilimsel toplantıda sunulmuş ve tam metni basılmış sözlü bildiri', 'kategori' => 'tez_yayini', 'kaynaklar' => ['CPCI Bildiri'], 'puan' => 3],

        "{$on}-3a" => ['baslik' => 'Tanınmış uluslararası yayınevi tarafından yayımlanan özgün bilimsel kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 20],
        "{$on}-3b" => ['baslik' => 'Tanınmış uluslararası yayınevi kitabında bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 10],
        "{$on}-3b-ed" => ['baslik' => 'Tanınmış uluslararası yayınevi tarafından yayımlanan özgün bilimsel kitabın editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 10],
        "{$on}-3c" => ['baslik' => 'Tanınmış ulusal yayınevi tarafından yayımlanmış özgün bilimsel kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)', 'Ders / Metot Kitabı'], 'puan' => 15],
        "{$on}-3d" => ['baslik' => 'Tanınmış ulusal yayınevi kitabında bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 8],
        "{$on}-3d-ed" => ['baslik' => 'Tanınmış ulusal yayınevi tarafından yayımlanmış özgün bilimsel kitabın editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 8],

        ...$dortuncuMadde,

        "{$on}-5a" => ['baslik' => 'Uluslararası endeksli dergilerde ya da tanınmış uluslararası yayınevi kitaplarında eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'BKCI Kitap'], 'puan' => 3],
        "{$on}-5b" => ['baslik' => 'Bu endeksler dışındaki uluslararası hakemli dergilerde eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer (Uluslararası)'], 'puan' => 2],
        "{$on}-5c" => ['baslik' => 'Ulusal hakemli dergilerde ya da tanınmış ulusal yayınevi kitaplarında eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Patent'], 'puan' => 1],

        "{$on}-6a" => ['baslik' => 'Tamamlanmış doktora tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 4],
        "{$on}-6b" => ['baslik' => 'Tamamlanmış yüksek lisans tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 2],

        "{$on}-7a" => ['baslik' => 'AB Çerçeve Programı projesinde koordinatör ya da baş araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['yurutucu'], 'puan' => 15],
        "{$on}-7b" => ['baslik' => 'AB Çerçeve Programı projesinde ortak araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
        "{$on}-7c" => ['baslik' => 'Diğer uluslararası destekli bilimsel araştırma projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 8],
        "{$on}-7d" => ['baslik' => 'Üniversite dışındaki kamu kurumlarıyla yapılan bilimsel araştırma projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 6],

        "{$on}-8a" => ['baslik' => 'Uluslararası bilimsel toplantıda sunulmuş ve tam metni basılmış sözlü bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 3],
        "{$on}-8b" => ['baslik' => 'Ulusal bilimsel toplantıda sunulmuş ve tam metni basılmış sözlü bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 2],

        "{$on}-9a" => ['baslik' => 'Bir dönem yüksek lisans veya doktora dersi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 3],
        "{$on}-9b" => ['baslik' => 'Bir dönem ön lisans veya lisans dersi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'], 'puan' => 1],
    ];
};

$E1 = $ekGovdesi(
    $SCI,
    ['ESCI / Scopus', 'Diğer Uluslararası İndeks'],
    ['SCIE/SSCI/AHCI'],
    [
        'E1-4a' => ['baslik' => 'Uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 20],
        'E1-4b' => ['baslik' => 'Ulusal patent, faydalı model ya da benzeri sınai hak', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent', 'Faydalı Model', 'Endüstriyel Tasarım', 'Yazılım', 'Islahçı Hakkı / Çeşit Tescili', 'Ticarileştirme'], 'puan' => 10],
    ],
    'E1',
);

$E2 = $ekGovdesi(
    [...$SCI, 'ESCI / Scopus'],
    ['Diğer Uluslararası İndeks'],
    ['SCIE/SSCI/AHCI', 'ESCI / Scopus'],
    [
        'E2-4a' => ['baslik' => 'Meslek odaları, yerel yönetimler, bakanlıklar ya da uluslararası kuruluşların düzenlediği planlama, mimarlık, kentsel tasarım, peyzaj, iç mimari ya da endüstri ürünleri tasarımı yarışmasında derece', 'kategori' => 'odul', 'kaynaklar' => ['Yarışma Derecesi / Mansiyon', 'Uluslararası Bilim/Sanat Ödülü', 'Ulusal Bilim/Sanat Ödülü'], 'puan' => 7],
        'E2-4b' => ['baslik' => 'Ürettiğiniz bir uygulama projesi hakkında hakemli dergide makale, kitap bölümü ya da kitap', 'kategori' => 'sanatsal_etkinlik', 'kaynaklar' => ['Uygulama Projesi — Müellif', 'Uygulama Projesi — Ekip', 'Uygulama Projesi — Ekip Yardımcısı', 'Uygulama Projesi — Danışman', 'Koruma-Onarım Uygulaması (Uluslararası)', 'Koruma-Onarım Uygulaması (Ulusal)'], 'puan' => 15],
        'E2-4c' => ['baslik' => 'Proje ve yapım yönetimi, tasarım ya da planlama alanlarında yazılım üreticisi veya patent sahibi olmak', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent', 'Ulusal Patent', 'Faydalı Model', 'Endüstriyel Tasarım', 'Yazılım', 'Islahçı Hakkı / Çeşit Tescili', 'Ticarileştirme'], 'puan' => 15],
    ],
    'E2',
);

$E3 = [
    'E3-1a' => ['baslik' => 'SCI, SCI-Expanded, SSCI veya AHCI kapsamındaki uluslararası hakemli dergide yayımlanmış özgün tam araştırma makalesi', 'kategori' => 'makale', 'kaynaklar' => $SCI, 'turler' => ['ozgun_makale'], 'puan' => 20],
    'E3-1b' => ['baslik' => 'Eğitim Bilimleri ya da Yabancı Dil Eğitimi alan endekslerinde taranan uluslararası hakemli dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'turler' => ['ozgun_makale'], 'puan' => 15],
    'E3-1c' => ['baslik' => 'Uluslararası dergide yayımlanmış kitap kritiği ya da benzeri kısa yayın', 'kategori' => 'makale', 'kaynaklar' => [...$SCI, 'ESCI / Scopus'], 'turler' => ['kisa_makale', 'vaka_teknik_not'], 'puan' => 5],
    'E3-1d' => ['baslik' => 'ULAKBİM tarafından taranan ulusal hakemli dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => ['ozgun_makale'], 'puan' => 8],
    'E3-1e' => ['baslik' => 'Diğer ulusal hakemli dergide yayımlanmış makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli', 'Diğer Uluslararası İndeks'], 'turler' => ['ozgun_makale'], 'puan' => 4],

    'E3-2a' => ['baslik' => 'Lisansüstü tezinizle ilgili, uluslararası hakemli dergide yayımlanmış makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['SCIE/SSCI/AHCI', 'ESCI / Scopus'], 'puan' => 8],
    'E3-2b' => ['baslik' => 'Lisansüstü tezinizle ilgili, diğer uluslararası ya da ulusal hakemli dergide yayımlanmış makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Diğer', 'TR Dizin'], 'puan' => 6],
    'E3-2c-2d' => ['baslik' => 'Lisansüstü tezinizle ilgili, bilimsel toplantıda sunulmuş ve tam metni basılmış sözlü bildiri', 'kategori' => 'tez_yayini', 'kaynaklar' => ['CPCI Bildiri'], 'puan' => 3],
    'E3-2e' => ['baslik' => 'Lisansüstü tezinizle ilgili, uluslararası yayınevi tarafından yayımlanmış kitap', 'kategori' => 'tez_yayini', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 10],
    'E3-2f' => ['baslik' => 'Lisansüstü tezinizle ilgili, uluslararası yayınevi kitabında bölüm', 'kategori' => 'tez_yayini', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 8],
    'E3-2g' => ['baslik' => 'Lisansüstü tezinizle ilgili, ulusal yayınevi tarafından yayımlanmış kitap', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 5],
    'E3-2h' => ['baslik' => 'Lisansüstü tezinizle ilgili, ulusal yayınevi kitabında bölüm', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 4],

    'E3-3a' => ['baslik' => 'Tanınmış uluslararası yayınevi tarafından yayımlanan özgün bilimsel kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 20],
    'E3-3b' => ['baslik' => 'Tanınmış uluslararası yayınevi tarafından yayımlanan özgün bilimsel kitabın editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 10],
    'E3-3c' => ['baslik' => 'Tanınmış uluslararası yayınevi kitabında bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 10],
    'E3-3d' => ['baslik' => 'Tanınmış ulusal yayınevi tarafından yayımlanmış kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)', 'Ders / Metot Kitabı'], 'puan' => 15],
    'E3-3e' => ['baslik' => 'Ulusal yayınevi kitabında bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 8],
    'E3-3e-ed' => ['baslik' => 'Ulusal yayınevi tarafından yayımlanmış kitabın editörlüğü', 'kategori' => 'editorluk', 'kaynaklar' => ['Kitap Editörlüğü'], 'puan' => 8],

    'E3-4a' => ['baslik' => 'Uluslararası endeksli dergilerde ya da tanınmış uluslararası yayınevi kitaplarında eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus', 'BKCI Kitap'], 'puan' => 3],
    'E3-4b' => ['baslik' => 'Bu endeksler dışındaki uluslararası hakemli dergilerde eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer (Uluslararası)'], 'puan' => 2],
    'E3-4c' => ['baslik' => 'Ulusal hakemli dergilerde ya da tanınmış ulusal yayınevi kitaplarında eserlerinize yapılan atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin', 'Patent'], 'puan' => 1],

    'E3-5a' => ['baslik' => 'Tamamlanmış doktora tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'], 'roller' => ['danisman'], 'puan' => 4],
    'E3-5b' => ['baslik' => 'Tamamlanmış yüksek lisans tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'roller' => ['danisman'], 'puan' => 2],

    'E3-6a' => ['baslik' => 'AB Çerçeve Programı projesinde koordinatör ya da baş araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['yurutucu'], 'puan' => 15],
    'E3-6b' => ['baslik' => 'AB Çerçeve Programı projesinde ortak araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk'], 'roller' => ['arastirmaci', 'danisman', 'bursiyer'], 'puan' => 10],
    'E3-6c' => ['baslik' => 'Diğer uluslararası destekli bilimsel araştırma projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'roller' => ['yurutucu'], 'puan' => 6],
    'E3-6d' => ['baslik' => 'Üniversite dışındaki kamu kurumlarıyla yapılan bilimsel araştırma projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'roller' => ['yurutucu'], 'puan' => 4],

    'E3-7a' => ['baslik' => 'Uluslararası bilimsel toplantıda sunulmuş ve tam metni basılmış sözlü bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin'], 'puan' => 3],
    'E3-7b' => ['baslik' => 'Ulusal bilimsel toplantıda sunulmuş ve tam metni basılmış sözlü bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 2],

    'E3-8a' => ['baslik' => 'Bir dönem yüksek lisans veya doktora dersi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisansüstü Ders'], 'puan' => 3],
    'E3-8b' => ['baslik' => 'Bir dönem ön lisans veya lisans dersi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Lisans/Önlisans Ders', 'Değişim Programı Dersi'], 'puan' => 2],
    'E3-8c' => ['baslik' => 'Bir dönem yabancı dil hazırlık dersi', 'kategori' => 'egitim_ogretim', 'kaynaklar' => ['Yabancı Dilde Ders'], 'puan' => 2],
];

/**
 * Ek-1 ve Ek-2'nin ortak grup iskeleti.
 *
 * @return array<string, list<string>>
 */
$ekGruplari = fn (string $on, array $dortKodlari): array => [
    "{$on}-1" => ["{$on}-1a", "{$on}-1b", "{$on}-1c"],
    "{$on}-1a" => ["{$on}-1a"],
    "{$on}-1a-2a" => ["{$on}-1a", "{$on}-2a"],
    "{$on}-2" => ["{$on}-2a", "{$on}-2b", "{$on}-2c-2d"],
    "{$on}-3" => ["{$on}-3a", "{$on}-3b", "{$on}-3b-ed", "{$on}-3c", "{$on}-3d", "{$on}-3d-ed"],
    "{$on}-4" => $dortKodlari,
    "{$on}-5" => ["{$on}-5a", "{$on}-5b", "{$on}-5c"],
    "{$on}-6" => ["{$on}-6a", "{$on}-6b"],
    "{$on}-7" => ["{$on}-7a", "{$on}-7b", "{$on}-7c", "{$on}-7d"],
    "{$on}-8" => ["{$on}-8a", "{$on}-8b"],
    "{$on}-9" => ["{$on}-9a", "{$on}-9b"],
];

$E1Gruplari = $ekGruplari('E1', ['E1-4a', 'E1-4b']);
$E2Gruplari = $ekGruplari('E2', ['E2-4a', 'E2-4b', 'E2-4c']);
$E2Gruplari['E2-4-7'] = ['E2-4', 'E2-7'];

$E3Gruplari = [
    'E3-1' => ['E3-1a', 'E3-1b', 'E3-1c', 'E3-1d', 'E3-1e'],
    'E3-1a' => ['E3-1a'],
    'E3-1a-2a' => ['E3-1a', 'E3-2a'],
    'E3-2' => ['E3-2a', 'E3-2b', 'E3-2c-2d', 'E3-2e', 'E3-2f', 'E3-2g', 'E3-2h'],
    'E3-3' => ['E3-3a', 'E3-3b', 'E3-3c', 'E3-3d', 'E3-3e', 'E3-3e-ed'],
    'E3-4' => ['E3-4a', 'E3-4b', 'E3-4c'],
    'E3-5' => ['E3-5a', 'E3-5b'],
    'E3-6' => ['E3-6a', 'E3-6b', 'E3-6c', 'E3-6d'],
    'E3-7' => ['E3-7a', 'E3-7b'],
    'E3-8' => ['E3-8a', 'E3-8b', 'E3-8c'],
    'E3-YENIDEN' => ['E3-1a', 'E3-4', 'E3-6', 'E3-8'],
];

$not = fn (string $ek, string $ozel): string => 'Puanlar İzmir Yüksek Teknoloji Enstitüsü Minimum '
    ."Akademik Yükseltme ve Atama Ölçütleri {$ek} puanlama sisteminden. Yazar çarpanı yönergenin "
    .'Tanımlar bölümüne göre işliyor: tek yazar tam puan; başlıca yazarın belirtildiği iki '
    .'yazarlı eserde başlıca yazar 0,80, ikinci yazar 0,50; üç ve daha fazla yazarlıda başlıca '
    .'yazar yarısını, diğerleri kalan yarıyı eşit paylaşır; başlıca yazar belirtilmemişse puan '
    .'yazar sayısına bölünür. Yazar listesini boş bırakırsanız çarpan hiç uygulanmaz ve puanınız '
    .'olduğundan YÜKSEK görünür. '
    .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: yönergenin 1. maddesi derlemeyi, editöre '
    .'mektubu, teknik notu ve kitap kritiğini açıkça dışladığı için bu türler hiç sayılmıyor; '
    .'bilimsel toplantı bölümünde yalnızca tam metni basılmış sözlü bildiri puanlanıyor (poster, '
    .'özet ve davetli konuşmacılık satırı yok); araştırma projelerinde AB dışındaki projelerde '
    .'yalnızca yürütücülük puanlanıyor ve BAP projelerine satır yok; dergi editörlüğü ve '
    .'hakemliği, idari görev, ödül ve toplumsal katkı kalemlerine puanlama sisteminde hiç satır '
    .'yok. '.$ozel
    .' Puanınız şu kalemde OLDUĞUNDAN YÜKSEK görünebilir: atıf puanı yönergede "adayın atıf '
    .'yapılan her eseri için" veriliyor, kayıt ise atıf başına tutuluyor.';

$cetveller = [];

// Ek-1 ve Ek-2'nin 9. madde tavanı kadroya bağlı: doçentlikte 6, profesörlükte 10.
foreach (['dr' => null, 'docent' => 6, 'profesor' => 10] as $kadro => $egitimTavani) {
    $cetveller["iyte-2018-e1-{$kadro}"] = [
        'kapsam_notu' => $not('Ek-1 (Fen ve Mühendislik Temel Alan)',
            'Ek-1\'de yalnızca ULAKBİM tarafından taranan ulusal dergilerin satırı var; diğer '
            .'ulusal hakemli dergilerdeki makaleniz puansız. Kitap bölümünden en fazla 10 puan '
            .'alınabiliyor.'
            .($egitimTavani === null ? '' : " Eğitim öğretim faaliyetlerinden bu kadroda en fazla {$egitimTavani} puan alınabiliyor.")),
        'yazar_katsayisi' => $yazarKatsayisi,
        'maddeler' => $E1,
        'gruplar' => $E1Gruplari,
        'grup_tavanlari' => $egitimTavani === null ? ['E1-3' => 10] : ['E1-3' => 10, 'E1-9' => $egitimTavani],
    ];

    $cetveller["iyte-2018-e2-{$kadro}"] = [
        'kapsam_notu' => $not('Ek-2 (Mimarlık, Planlama ve Tasarım Temel Alan)',
            'Ek-2\'nin 4. maddesindeki yarışma derecesi yönergede "ekip başı tam puanın 0,8\'ini, '
            .'diğerleri 0,5\'ini alır" dediği ve rol kayıtta tutulmadığı için en düşük paydan '
            .'(7 puan) sayılıyor. Kitap bölümünden en fazla 15 puan alınabiliyor.'
            .($egitimTavani === null ? '' : " Eğitim öğretim faaliyetlerinden bu kadroda en fazla {$egitimTavani} puan alınabiliyor.")),
        'yazar_katsayisi' => $yazarKatsayisi,
        'maddeler' => $E2,
        'gruplar' => $E2Gruplari,
        'grup_tavanlari' => $egitimTavani === null ? ['E2-3' => 15] : ['E2-3' => 15, 'E2-9' => $egitimTavani],
    ];
}

$cetveller['iyte-2018-e3'] = [
    'kapsam_notu' => $not('Ek-3 (Eğitim Bilimleri Temel Alanı)',
        'Ek-3\'te "Eğitim Bilimleri Temel Alanı endeksleri" ile "Yabancı Dil Eğitimi alan '
        .'endeksleri" aynı kayıt etiketine düştüğü için ikisi de düşük olan 15 puandan '
        .'sayılıyor; diğer uluslararası indeksli dergilerin karşılığı olmadığı için o yayınlar '
        .'en düşük ulusal satırdan (4 puan) sayılıyor.'),
    'yazar_katsayisi' => $yazarKatsayisi,
    'maddeler' => $E3,
    'gruplar' => $E3Gruplari,
    'grup_tavanlari' => [],
];

return ['cetveller' => $cetveller];
