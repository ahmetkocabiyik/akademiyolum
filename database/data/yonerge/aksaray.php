<?php

/**
 * AKSARAY ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma Yönergesi
 * Kaynak: pdf/17634002431.Aksaray Üniversitesi Kriter.pdf (18 sayfa,
 * Senato 06.11.2024/2024-30-03, YÖK onayı 21.11.2024)
 *
 * ── YAPI: TABLO-2'NİN YEDİ ALAN TABLOSU ──
 * Tablo-1 (puan cetveli) üniversite geneli ortak; Tablo-2 yedi alanın her
 * biri için ayrı ADET + kategori bazlı asgari puan + TOPLAM tablosu veriyor:
 *
 *   A. Eğitim Bilimleri              → alan: egitim
 *   B. Fen ve Mühendislik Bilimleri  → alan: fen, mühendislik
 *   C. Güzel Sanatlar                → alan: guzel_sanatlar
 *   D. Mimarlık ve Tasarım           → alan: mimarlik
 *   E. Sağlık Bilimleri              → alan: saglik
 *   F. Sosyal, Beşeri ve İdari Bilimler → alan: sosyal, hukuk, filoloji, ilahiyat
 *   G. Spor Bilimleri                → alan: spor
 *
 * Sosyal tablosu Türk Dili/Hukuk/İlahiyat gibi bölümleri ayrı anmıyor; bu üç
 * alan Aksaray'ın yedi tablosunun hiçbirinde YOKTUR, en yakın kapsam "Sosyal,
 * Beşeri ve İdari Bilimler" başlığı olduğu için oraya eklendi (diğer
 * yönergelerde de görülen bir yaklaşım, ör. Ankara Bilim).
 *
 * Ziraat, orman ve su ürünleri alanı yönergede hiç anılmıyor; kapsam dışı
 * bırakıldı.
 *
 * ── GÜZEL SANATLAR TABLOSUNDAKİ "L (Sanat Etkinlikleri)" SATIRI: KAYNAK
 * HATASI, K OLARAK OKUNDU ──
 * Tablo-2'nin Güzel Sanatlar bölümü alt şartlarından biri "L (Sanat
 * Etkinlikleri)" diye anılıyor, ama Tablo-1'de "L" harfi SPOR
 * ETKİNLİKLERİ'ne ait (olimpiyat madalyaları vb.), sanat etkinlikleri ise
 * "K. SANAT, MİMARLIK VE TASARIM ALANI ETKİNLİKLERİ" bölümünde. Satırın
 * kendi parantez içi adı ("Sanat Etkinlikleri") K bölümünün başlığıyla
 * birebir örtüşüyor; kaynaktaki harf hatası kabul edilip K grubu kullanıldı
 * (KONVANSIYONLAR'daki "kaynaktaki hatayı düzeltme, olduğu gibi gir" kuralı
 * burada uygulanamazdı çünkü hata bir MİKTAR değil bir ATIF hatası — hangi
 * kategoriye işaret ettiği içerikten açıkça çıkarılabiliyor).
 *
 * ── "TEZDEN ÜRETİLEN YAYINLAR HARİÇ" AYRICA YAZILMADI ──
 * Her alanın her adet şartı "adayın lisansüstü tezlerinden üretilen
 * yayınları hariç" diyor. `makale` kategorisindeki bir faaliyet zaten
 * `tez_yayini` kategorisinden farklı bir kayıt olduğu için (aday aynı
 * çalışmayı iki kategoride birden tutamaz) bu dışlama örtük olarak
 * sağlanıyor; ayrı bir koşul yazılmadı.
 *
 * ── "TEK YAZAR" İLE "BAŞLICA YAZAR" AYRIMI KORUNDU ──
 * Yönergenin bazı alanları (Güzel Sanatlar, Sosyal) özellikle "tek yazar"
 * istiyor, bazıları "başlıca yazar" (tek/ilk/sorumlu yazar) yeterli
 * sayıyor. Motorun `yazar: 'tek'` ve `yazar: 'baslica'` ayrımı metne sadık
 * kalınarak uygulandı — "tek yazar" istenen yerlerde `baslica` KULLANILMADI.
 *
 * ── YENİDEN ATANMA: "SON ATAMA TARİHİNDEN İTİBAREN" ──
 * Madde 9/4: yeniden atanma şartlarının (yabancı dil hariç) SON ATAMA
 * TARİHİNDEN İTİBAREN sağlanmış olması gerekiyor. Dr. Öğr. Üyesi yeniden
 * atanma eşiğindeki tüm adet/puan/toplam koşulları `SON_ATAMA_SONRASI`
 * dönemine bağlandı.
 *
 * ── BİLDİRİ/PROJE TELAFİSİ: SABİT %5, EKSİĞE ORANTILI DEĞİL ──
 * Her alanın kendi dipnotu: "Bildiride/Projede asgari puanın
 * sağlanmaması durumunda atamaya esas unvan için gereken TOPLAM asgari
 * puanın en az %5'i makale kategorisinden İLAVE olarak sağlanmak
 * durumundadır." Bu, Trabzon'daki "eksiğin N katı" telafisinden farklı:
 * miktar EKSİĞE ORANTILI DEĞİL, o unvanın toplam barajının SABİT %5'i.
 * Motorun `telafi` alanına `telafi_carpani` YAZILMADI (o alan yalnızca
 * eksikle orantılı miktarlar için); bunun yerine telafi düğümünün kendi
 * `min_puan`ı doğrudan `ceil(toplam × 0,05)` olarak sabitlendi.
 *
 * ── YABANCI DİL: YALNIZCA İLK ATANMALARDA ──
 * Madde 6/6 Türkçe eğitim veren birimlerde YDS/YÖKDİL'den asgari 65 puan
 * istiyor ve aynı fıkra "yeniden atamalarda yabancı dil şartı aranmaz"
 * diyor. `Kalip::yds(65)` bu yüzden yalnızca 21 ilk atanma eşiğine yazıldı,
 * yedi yeniden atanma eşiğine yazılmadı.
 *
 * ── GİRİLMEYEN ALT ŞARTLAR ──
 *   Mimarlık ve Tasarım alanında K (Sanat/Mimarlık/Tasarım Etkinlikleri)
 *       kategorisi Tablo-2'de hiç alt şart olarak talep edilmiyor (yalnızca
 *       TOPLAM'a serbest katkı sağlıyor); eşiğe yazılmadı.
 *   Madde 6/7'nin "yabancı dilde eğitim yapan birimlerde deneme dersinden
 *       en az 85 puan" ve Madde 6/8'in "ikinci yabancı dilden en az 65 puan"
 *       şartları — birimin eğitim dili profilde yok, hangi adayın bu şarta
 *       tabi olduğu belirlenemiyor; hiç yazılmadı.
 *   Profesörlükte "başlıca araştırma eseri" sunma zorunluluğu (Madde 11/1-b)
 *       — hangi yayının "başlıca araştırma eseri" olarak sunulduğu adayın
 *       kendi seçimi, faaliyet kaydından çıkarılamaz; beyan olarak eklendi.
 *   Madde 6/15'in öğretim üyesi eksiği olan tıp/diş hekimliği anabilim
 *       dallarında puan ve diğer şartları sağlamayan adayların da
 *       değerlendirmeye alınabilmesi — tamamen idari takdire bağlı, eşik
 *       yazılmadı.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/aksaray-2024.php
 */

use App\Services\Scoring\Sart\Kalip;

$CETVEL = 'aksaray-2024';
$UNIVERSITE = 'Aksaray Üniversitesi';
$DOKTORA = Kalip::DOKTORA_SONRASI;
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;
$SON_ATAMA = Kalip::SON_ATAMA_SONRASI;

/**
 * "Bildiride/Projede asgari puan sağlanamazsa, unvanın toplam barajının en
 * az %5'i makale kategorisinden ilave sağlanmalı" telafisi.
 *
 * @param  list<string>  $maddeler
 * @param  array<string, mixed>|null  $donem
 * @return array<string, mixed>
 */
$puanTelafili = function (
    string $aciklama, array $maddeler, int $puan, int $toplamBaraji, ?array $donem, string $madde,
): array {
    $maddeler = array_values($maddeler);

    return Kalip::puanDan($aciklama, $maddeler, $puan, $donem, madde: $madde) + [
        'telafi' => [
            'tip' => 'puan',
            'aciklama' => 'Bu puanı sağlayamazsanız: atamaya esas unvanın toplam barajının en '
                .'az %5\'ini fazladan makale kalemlerinden sağlamalısınız',
            'madde' => $madde,
            'maddeler' => ['A-TUM'],
            'min_puan' => (int) ceil($toplamBaraji * 0.05),
            'donem' => $donem,
        ],
    ];
};

$esikler = [];

// ══════════════════════════════════════════════════════════════════════════
// A. EĞİTİM BİLİMLERİ ALANI
// ══════════════════════════════════════════════════════════════════════════

$esikler[] = [
    'anahtar' => 'aksaray-egitim-dr',
    'aday_notu' => 'A kategorisinden (makaleler) en az 3 adet yayınınız, bunlardan en az 1 '
        .'tanesi doktora unvanınızdan sonra A.1 kategorisinden (SCI-Expanded/SSCI/AHCI) olmalı; '
        .'A kalemlerinizden en az 30 puan ve tüm faaliyetlerden toplamda en az 100 puan '
        .'(bunun en az 60\'ı doktora sonrası) gerekiyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi',
    'alan' => ['egitim'],
    'cetvel' => $CETVEL,
    'notlar' => 'Tablo-2/A, Dr. Öğr. Üyesi İlk Atanma: adet 3 (a: en az 1 A.1\'den doktora '
        .'sonrası); A puanı 30; toplam 100 (60\'ı doktora sonrası).',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna atanma', [
        Kalip::yds(65),
        Kalip::beyan('İlgili alanda doktora derecesine sahip olmak', 'Tablo-2/A'),
        Kalip::adet('A.1 kategorisinde (SCI-Expanded/SSCI/AHCI) doktora unvanınızdan sonra en az 1 yayınınız olmalı', ['A.1-TUM'], 1, donem: $DOKTORA, madde: 'Tablo-2/A-a'),
        Kalip::adet('A kategorisinden (makaleler) toplam en az 3 yayınınız olmalı', ['A.1-A.4'], 3, madde: 'Tablo-2/A-a'),
        Kalip::puanDan('Makale kalemlerinizden en az 30 puan', ['A-TUM'], 30, madde: 'Tablo-2/A'),
        Kalip::puanDan('Bu puanın en az 60\'ı doktora unvanınızdan sonra olmalı', ['A-TUM'], 60, $DOKTORA, madde: 'Tablo-2/A-g'),
        Kalip::toplam(100),
    ]),
];

$esikler[] = [
    'anahtar' => 'aksaray-egitim-dr-yeniden',
    'aday_notu' => 'Son atama tarihinizden SONRAKİ faaliyetlerinize bakılıyor: A kategorisinden '
        .'en az 2 yayınınız (en az 1\'i A.1-A.3\'ten), en az 20 puan; bildiri kalemlerinizden '
        .'en az 4 puan (sağlayamazsanız toplam barajın %5\'ini makaleden fazladan '
        .'sağlamalısınız); proje kalemlerinizden en az 4 puan (aynı telafi); toplamda en az '
        .'60 puan gerekiyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi_yeniden',
    'alan' => ['egitim'],
    'cetvel' => $CETVEL,
    'notlar' => 'Tablo-2/A, Yeniden Atanma: adet 2 (b: en az 1 A.1-A.3\'ten); A puanı 20; B '
        .'puanı 4 (telafi e); F puanı 4 (telafi f); toplam 60. Madde 9/4: son atama tarihinden '
        .'itibaren.',
    'sart' => Kalip::ve('Doktor Öğretim Üyeliğine yeniden atanma', [
        Kalip::adet('Son atama tarihinizden sonra A.1-A.3 kategorisinde en az 1 yayınınız olmalı', ['A.1-A.3'], 1, donem: $SON_ATAMA, madde: 'Tablo-2/A-b'),
        Kalip::adet('Son atama tarihinizden sonra A kategorisinden toplam en az 2 yayınınız olmalı', ['A.1-A.4'], 2, donem: $SON_ATAMA, madde: 'Tablo-2/A-b'),
        Kalip::puanDan('Son atama tarihinizden sonra makale kalemlerinizden en az 20 puan', ['A-TUM'], 20, $SON_ATAMA, madde: 'Tablo-2/A'),
        $puanTelafili('Son atama tarihinizden sonra bildiri kalemlerinizden en az 4 puan', ['B-TUM'], 4, 60, $SON_ATAMA, 'Tablo-2/A-e'),
        $puanTelafili('Son atama tarihinizden sonra araştırma projesi kalemlerinizden en az 4 puan', ['F-TUM'], 4, 60, $SON_ATAMA, 'Tablo-2/A-f'),
        Kalip::toplam(60, $SON_ATAMA),
    ]),
];

$esikler[] = [
    'anahtar' => 'aksaray-egitim-docent',
    'aday_notu' => 'A kategorisinden en az 6 yayınınız, bunlardan en az 2\'si doktora '
        .'unvanınızdan sonra A.1\'den olmalı; A kalemlerinizden en az 60 puan; bildiri '
        .'kalemlerinizden en az 6 puan (telafi ile); atıf kalemlerinizden en az 10 puan; '
        .'araştırma projesi kalemlerinizden en az 6 puan (telafi ile); toplamda en az 200 '
        .'puan gerekiyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => ['egitim'],
    'cetvel' => $CETVEL,
    'notlar' => 'Tablo-2/A, Doçent: adet 6 (c: en az 2 A.1\'den doktora sonrası); A puanı 60; '
        .'B puanı 6 (telafi e); E puanı 10; F puanı 6 (telafi f); toplam 200.',
    'sart' => Kalip::ve('Doçent kadrosuna atanma', [
        Kalip::yds(65),
        Kalip::beyan('ÜAK doçentlik unvanına sahip olmak', 'Madde 10'),
        Kalip::adet('A.1 kategorisinde doktora unvanınızdan sonra en az 2 yayınınız olmalı', ['A.1-TUM'], 2, donem: $DOKTORA, madde: 'Tablo-2/A-c'),
        Kalip::adet('A kategorisinden toplam en az 6 yayınınız olmalı', ['A.1-A.4'], 6, madde: 'Tablo-2/A-c'),
        Kalip::puanDan('Makale kalemlerinizden en az 60 puan', ['A-TUM'], 60, madde: 'Tablo-2/A'),
        $puanTelafili('Bildiri kalemlerinizden en az 6 puan', ['B-TUM'], 6, 200, null, 'Tablo-2/A-e'),
        Kalip::puanDan('Atıf kalemlerinizden en az 10 puan', ['E-TUM'], 10, madde: 'Tablo-2/A'),
        $puanTelafili('Araştırma projesi kalemlerinizden en az 6 puan', ['F-TUM'], 6, 200, null, 'Tablo-2/A-f'),
        Kalip::toplam(200),
    ]),
];

$esikler[] = [
    'anahtar' => 'aksaray-egitim-profesor',
    'aday_notu' => 'A kategorisinden en az 12 yayınınız, bunlardan 6\'sı doçentlik '
        .'unvanınızdan sonra olmalı ve en az 3\'ü A.1-A.3\'ten olmalı; A kalemlerinizden en az '
        .'120 puan; bildiri kalemlerinizden en az 10 puan (telafi ile); atıf kalemlerinizden '
        .'en az 15 puan; araştırma projesi kalemlerinizden en az 10 puan (telafi ile); '
        .'toplamda en az 300 puan gerekiyor. Ayrıca doçentlik sonrası yayınlarınızdan birini '
        .'başlıca araştırma eseri olarak sunmalısınız.',
    'universite' => $UNIVERSITE,
    'kadro' => 'profesorluk',
    'alan' => ['egitim'],
    'cetvel' => $CETVEL,
    'notlar' => 'Tablo-2/A, Profesör: adet 12 (d: altısı doçentlik sonrası, en az 3\'ü '
        .'A1-A3\'ten); A puanı 120; B puanı 10 (telafi e); E puanı 15; F puanı 10 (telafi f); '
        .'toplam 300. Madde 11/1-b: başlıca araştırma eseri.',
    'sart' => Kalip::ve('Profesör kadrosuna atanma', [
        Kalip::yds(65),
        Kalip::beyan('Doçentlik unvanına sahip olmak', 'Madde 11'),
        Kalip::beyan('Doçentlik unvanınızdan sonraki yayınlarınızdan birini başlıca araştırma eseri olarak sunmak', 'Madde 11/1-b'),
        Kalip::adet('A.1-A.3 kategorisinde doçentlik unvanınızdan sonra en az 3 yayınınız olmalı', ['A.1-A.3'], 3, donem: $DOCENTLIK, madde: 'Tablo-2/A-d'),
        Kalip::adet('Doçentlik unvanınızdan sonra A kategorisinden toplam en az 6 yayınınız olmalı', ['A.1-A.4'], 6, donem: $DOCENTLIK, madde: 'Tablo-2/A-d'),
        Kalip::adet('A kategorisinden toplam en az 12 yayınınız olmalı', ['A.1-A.4'], 12, madde: 'Tablo-2/A-d'),
        Kalip::puanDan('Makale kalemlerinizden en az 120 puan', ['A-TUM'], 120, madde: 'Tablo-2/A'),
        $puanTelafili('Bildiri kalemlerinizden en az 10 puan', ['B-TUM'], 10, 300, null, 'Tablo-2/A-e'),
        Kalip::puanDan('Atıf kalemlerinizden en az 15 puan', ['E-TUM'], 15, madde: 'Tablo-2/A'),
        $puanTelafili('Araştırma projesi kalemlerinizden en az 10 puan', ['F-TUM'], 10, 300, null, 'Tablo-2/A-f'),
        Kalip::toplam(300),
    ]),
];

// ══════════════════════════════════════════════════════════════════════════
// B. FEN VE MÜHENDİSLİK BİLİMLERİ ALANI
// ══════════════════════════════════════════════════════════════════════════

$esikler[] = [
    'anahtar' => 'aksaray-fen-muhendislik-dr',
    'aday_notu' => 'A kategorisinden en az 3 yayınınız, bunlardan en az 2\'si doktora '
        .'unvanınızdan sonra A.1\'den olmalı (en az biri başlıca yazarlı); A kalemlerinizden '
        .'en az 30 puan ve toplamda en az 100 puan (60\'ı doktora sonrası) gerekiyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi',
    'alan' => ['fen', 'muhendislik'],
    'cetvel' => $CETVEL,
    'notlar' => 'Tablo-2/B, Dr. Öğr. Üyesi İlk Atanma: adet 3 (a: en az biri başlıca yazarlı '
        .'olmak üzere 2\'si A.1\'den, doktora sonrası); A puanı 30; toplam 100 (60\'ı doktora '
        .'sonrası).',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna atanma', [
        Kalip::yds(65),
        Kalip::beyan('İlgili alanda doktora derecesine sahip olmak', 'Tablo-2/B'),
        Kalip::adet('A.1 kategorisinde doktora unvanınızdan sonra en az 2 yayınınız olmalı', ['A.1-TUM'], 2, donem: $DOKTORA, madde: 'Tablo-2/B-a'),
        Kalip::adet('Bu A.1 yayınlarınızdan en az birinde başlıca yazar olmalısınız', ['A.1-TUM'], 1, yazar: 'baslica', donem: $DOKTORA, madde: 'Tablo-2/B-a'),
        Kalip::adet('A kategorisinden toplam en az 3 yayınınız olmalı', ['A.1-A.4'], 3, madde: 'Tablo-2/B-a'),
        Kalip::puanDan('Makale kalemlerinizden en az 30 puan', ['A-TUM'], 30, madde: 'Tablo-2/B'),
        Kalip::puanDan('Bu puanın en az 60\'ı doktora unvanınızdan sonra olmalı', ['A-TUM'], 60, $DOKTORA, madde: 'Tablo-2/B-g'),
        Kalip::toplam(100),
    ]),
];

$esikler[] = [
    'anahtar' => 'aksaray-fen-muhendislik-dr-yeniden',
    'aday_notu' => 'Son atama tarihinizden SONRAKİ faaliyetlerinize bakılıyor: A kategorisinden '
        .'en az 2 yayınınız (en az 1\'i A.1\'den), en az 20 puan; bildiri kalemlerinizden en '
        .'az 4 puan (telafi ile); proje kalemlerinizden en az 4 puan (telafi ile); toplamda '
        .'en az 60 puan gerekiyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi_yeniden',
    'alan' => ['fen', 'muhendislik'],
    'cetvel' => $CETVEL,
    'notlar' => 'Tablo-2/B, Yeniden Atanma: adet 2 (b: en az 1 A.1\'den); A puanı 20; B puanı '
        .'4 (telafi e); F puanı 4 (telafi f); toplam 60.',
    'sart' => Kalip::ve('Doktor Öğretim Üyeliğine yeniden atanma', [
        Kalip::adet('Son atama tarihinizden sonra A.1 kategorisinde en az 1 yayınınız olmalı', ['A.1-TUM'], 1, donem: $SON_ATAMA, madde: 'Tablo-2/B-b'),
        Kalip::adet('Son atama tarihinizden sonra A kategorisinden toplam en az 2 yayınınız olmalı', ['A.1-A.4'], 2, donem: $SON_ATAMA, madde: 'Tablo-2/B-b'),
        Kalip::puanDan('Son atama tarihinizden sonra makale kalemlerinizden en az 20 puan', ['A-TUM'], 20, $SON_ATAMA, madde: 'Tablo-2/B'),
        $puanTelafili('Son atama tarihinizden sonra bildiri kalemlerinizden en az 4 puan', ['B-TUM'], 4, 60, $SON_ATAMA, 'Tablo-2/B-e'),
        $puanTelafili('Son atama tarihinizden sonra araştırma projesi kalemlerinizden en az 4 puan', ['F-TUM'], 4, 60, $SON_ATAMA, 'Tablo-2/B-f'),
        Kalip::toplam(60, $SON_ATAMA),
    ]),
];

$esikler[] = [
    'anahtar' => 'aksaray-fen-muhendislik-docent',
    'aday_notu' => 'A kategorisinden en az 6 yayınınız, bunlardan en az 3\'ü doktora '
        .'unvanınızdan sonra A.1\'den olmalı (en az biri başlıca yazarlı); A kalemlerinizden '
        .'en az 60 puan; bildiri kalemlerinizden en az 6 puan (telafi ile); atıf '
        .'kalemlerinizden en az 10 puan; araştırma projesi kalemlerinizden en az 6 puan '
        .'(telafi ile); toplamda en az 200 puan gerekiyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => ['fen', 'muhendislik'],
    'cetvel' => $CETVEL,
    'notlar' => 'Tablo-2/B, Doçent: adet 6 (c: en az biri başlıca yazarlı olmak üzere 3\'ü '
        .'A.1\'den, doktora sonrası); A puanı 60; B puanı 6 (telafi e); E puanı 10; F puanı 6 '
        .'(telafi f); toplam 200.',
    'sart' => Kalip::ve('Doçent kadrosuna atanma', [
        Kalip::yds(65),
        Kalip::beyan('ÜAK doçentlik unvanına sahip olmak', 'Madde 10'),
        Kalip::adet('A.1 kategorisinde doktora unvanınızdan sonra en az 3 yayınınız olmalı', ['A.1-TUM'], 3, donem: $DOKTORA, madde: 'Tablo-2/B-c'),
        Kalip::adet('Bu A.1 yayınlarınızdan en az birinde başlıca yazar olmalısınız', ['A.1-TUM'], 1, yazar: 'baslica', donem: $DOKTORA, madde: 'Tablo-2/B-c'),
        Kalip::adet('A kategorisinden toplam en az 6 yayınınız olmalı', ['A.1-A.4'], 6, madde: 'Tablo-2/B-c'),
        Kalip::puanDan('Makale kalemlerinizden en az 60 puan', ['A-TUM'], 60, madde: 'Tablo-2/B'),
        $puanTelafili('Bildiri kalemlerinizden en az 6 puan', ['B-TUM'], 6, 200, null, 'Tablo-2/B-e'),
        Kalip::puanDan('Atıf kalemlerinizden en az 10 puan', ['E-TUM'], 10, madde: 'Tablo-2/B'),
        $puanTelafili('Araştırma projesi kalemlerinizden en az 6 puan', ['F-TUM'], 6, 200, null, 'Tablo-2/B-f'),
        Kalip::toplam(200),
    ]),
];

$esikler[] = [
    'anahtar' => 'aksaray-fen-muhendislik-profesor',
    'aday_notu' => 'A kategorisinden en az 12 yayınınız, bunlardan 5\'i doçentlik unvanınızdan '
        .'sonra olmalı ve en az 4\'ü A.1\'den olmalı (en az biri başlıca yazarlı); A '
        .'kalemlerinizden en az 120 puan; bildiri kalemlerinizden en az 10 puan (telafi ile); '
        .'atıf kalemlerinizden en az 15 puan; araştırma projesi kalemlerinizden en az 10 puan '
        .'(telafi ile); toplamda en az 300 puan gerekiyor. Ayrıca doçentlik sonrası '
        .'yayınlarınızdan birini başlıca araştırma eseri olarak sunmalısınız.',
    'universite' => $UNIVERSITE,
    'kadro' => 'profesorluk',
    'alan' => ['fen', 'muhendislik'],
    'cetvel' => $CETVEL,
    'notlar' => 'Tablo-2/B, Profesör: adet 12 (d: beşi doçentlik sonrası, en az biri başlıca '
        .'yazarlı olmak üzere 4\'ü A.1\'den); A puanı 120; B puanı 10 (telafi e); E puanı 15; '
        .'F puanı 10 (telafi f); toplam 300. Madde 11/1-b: başlıca araştırma eseri.',
    'sart' => Kalip::ve('Profesör kadrosuna atanma', [
        Kalip::yds(65),
        Kalip::beyan('Doçentlik unvanına sahip olmak', 'Madde 11'),
        Kalip::beyan('Doçentlik unvanınızdan sonraki yayınlarınızdan birini başlıca araştırma eseri olarak sunmak', 'Madde 11/1-b'),
        Kalip::adet('A.1 kategorisinde doçentlik unvanınızdan sonra en az 4 yayınınız olmalı', ['A.1-TUM'], 4, donem: $DOCENTLIK, madde: 'Tablo-2/B-d'),
        Kalip::adet('Bu A.1 yayınlarınızdan en az birinde başlıca yazar olmalısınız', ['A.1-TUM'], 1, yazar: 'baslica', donem: $DOCENTLIK, madde: 'Tablo-2/B-d'),
        Kalip::adet('Doçentlik unvanınızdan sonra A kategorisinden toplam en az 5 yayınınız olmalı', ['A.1-A.4'], 5, donem: $DOCENTLIK, madde: 'Tablo-2/B-d'),
        Kalip::adet('A kategorisinden toplam en az 12 yayınınız olmalı', ['A.1-A.4'], 12, madde: 'Tablo-2/B-d'),
        Kalip::puanDan('Makale kalemlerinizden en az 120 puan', ['A-TUM'], 120, madde: 'Tablo-2/B'),
        $puanTelafili('Bildiri kalemlerinizden en az 10 puan', ['B-TUM'], 10, 300, null, 'Tablo-2/B-e'),
        Kalip::puanDan('Atıf kalemlerinizden en az 15 puan', ['E-TUM'], 15, madde: 'Tablo-2/B'),
        $puanTelafili('Araştırma projesi kalemlerinizden en az 10 puan', ['F-TUM'], 10, 300, null, 'Tablo-2/B-f'),
        Kalip::toplam(300),
    ]),
];

// ══════════════════════════════════════════════════════════════════════════
// C. GÜZEL SANATLAR ALANI
// ══════════════════════════════════════════════════════════════════════════

$esikler[] = [
    'anahtar' => 'aksaray-guzel-sanatlar-dr',
    'aday_notu' => 'A kategorisinden en az 3 yayınınız, bunlardan en az 2\'si doktora/sanatta '
        .'yeterlik unvanınızdan sonra A.1-A.4\'ten olmalı (en az biri tek yazarlı); A '
        .'kalemlerinizden en az 30 puan; sanat, mimarlık ve tasarım etkinliği kalemlerinizden '
        .'en az 25 puan ve toplamda en az 100 puan (60\'ı doktora/sanatta yeterlik sonrası) '
        .'gerekiyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi',
    'alan' => ['guzel_sanatlar'],
    'cetvel' => $CETVEL,
    'notlar' => 'Tablo-2/C, Dr. Öğr. Üyesi İlk Atanma: adet 3 (a: en az biri tek yazarlı '
        .'olmak üzere 2\'si A.1-A.4\'ten, doktora/sanatta yeterlik sonrası); A puanı 30; K '
        .'(kaynakta "L" — bkz. dosya başlığı) puanı 25; toplam 100 (60\'ı doktora/sanatta '
        .'yeterlik sonrası).',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna atanma', [
        Kalip::yds(65),
        Kalip::beyan('İlgili alanda doktora veya sanatta yeterlik derecesine sahip olmak', 'Tablo-2/C'),
        Kalip::adet('Doktora/sanatta yeterlik unvanınızdan sonra A1-A4 kategorisinde en az 2 yayınınız olmalı', ['A.1-A.4'], 2, donem: $DOKTORA, madde: 'Tablo-2/C-a'),
        Kalip::adet('Bu yayınlarınızdan en az birinde tek yazar olmalısınız', ['A.1-A.4'], 1, yazar: 'tek', donem: $DOKTORA, madde: 'Tablo-2/C-a'),
        Kalip::adet('A kategorisinden toplam en az 3 yayınınız olmalı', ['A.1-A.4'], 3, madde: 'Tablo-2/C-a'),
        Kalip::puanDan('Makale kalemlerinizden en az 30 puan', ['A-TUM'], 30, madde: 'Tablo-2/C'),
        Kalip::puanDan('Bu puanın en az 60\'ı doktora/sanatta yeterlik unvanınızdan sonra olmalı', ['A-TUM'], 60, $DOKTORA, madde: 'Tablo-2/C-g'),
        Kalip::puanDan('Sanat, mimarlık ve tasarım etkinliği kalemlerinizden en az 25 puan', ['K-TUM'], 25, madde: 'Tablo-2/C'),
        Kalip::toplam(100),
    ]),
];

$esikler[] = [
    'anahtar' => 'aksaray-guzel-sanatlar-dr-yeniden',
    'aday_notu' => 'Son atama tarihinizden SONRAKİ faaliyetlerinize bakılıyor: A kategorisinden '
        .'en az 2 yayınınız (en az 1\'inde başlıca yazar olmalısınız), en az 20 puan; bildiri '
        .'kalemlerinizden en az 4 puan (telafi ile); sanat etkinliği kalemlerinizden en az 20 '
        .'puan ve toplamda en az 60 puan gerekiyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi_yeniden',
    'alan' => ['guzel_sanatlar'],
    'cetvel' => $CETVEL,
    'notlar' => 'Tablo-2/C, Yeniden Atanma: adet 2 (b: en az 1\'i A1-A4\'te başlıca yazarlı); '
        .'A puanı 20; B puanı 4 (telafi e); K puanı 20; toplam 60.',
    'sart' => Kalip::ve('Doktor Öğretim Üyeliğine yeniden atanma', [
        Kalip::adet('Son atama tarihinizden sonra A1-A4 kategorisinde en az 1 başlıca yazarlı yayınınız olmalı', ['A.1-A.4'], 1, yazar: 'baslica', donem: $SON_ATAMA, madde: 'Tablo-2/C-b'),
        Kalip::adet('Son atama tarihinizden sonra A kategorisinden toplam en az 2 yayınınız olmalı', ['A.1-A.4'], 2, donem: $SON_ATAMA, madde: 'Tablo-2/C-b'),
        Kalip::puanDan('Son atama tarihinizden sonra makale kalemlerinizden en az 20 puan', ['A-TUM'], 20, $SON_ATAMA, madde: 'Tablo-2/C'),
        $puanTelafili('Son atama tarihinizden sonra bildiri kalemlerinizden en az 4 puan', ['B-TUM'], 4, 60, $SON_ATAMA, 'Tablo-2/C-e'),
        Kalip::puanDan('Son atama tarihinizden sonra sanat, mimarlık ve tasarım etkinliği kalemlerinizden en az 20 puan', ['K-TUM'], 20, $SON_ATAMA, madde: 'Tablo-2/C'),
        Kalip::toplam(60, $SON_ATAMA),
    ]),
];

$esikler[] = [
    'anahtar' => 'aksaray-guzel-sanatlar-docent',
    'aday_notu' => 'A kategorisinden en az 6 yayınınız, bunlardan en az 4\'ü doktora '
        .'unvanınızdan sonra A1-A4\'ten olmalı (en az biri tek yazarlı); A kalemlerinizden en '
        .'az 60 puan; bildiri kalemlerinizden en az 6 puan (telafi ile); atıf kalemlerinizden '
        .'en az 4 puan; araştırma projesi kalemlerinizden en az 4 puan (telafi ile); sanat '
        .'etkinliği kalemlerinizden en az 30 puan ve toplamda en az 200 puan gerekiyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => ['guzel_sanatlar'],
    'cetvel' => $CETVEL,
    'notlar' => 'Tablo-2/C, Doçent: adet 6 (c: en az biri tek yazarlı olmak üzere 4\'ü '
        .'A1-A4\'ten, doktora sonrası); A puanı 60; B puanı 6 (telafi e); E puanı 4; F puanı 4 '
        .'(telafi f); K puanı 30; toplam 200.',
    'sart' => Kalip::ve('Doçent kadrosuna atanma', [
        Kalip::yds(65),
        Kalip::beyan('ÜAK doçentlik unvanına sahip olmak', 'Madde 10'),
        Kalip::adet('Doktora unvanınızdan sonra A1-A4 kategorisinde en az 4 yayınınız olmalı', ['A.1-A.4'], 4, donem: $DOKTORA, madde: 'Tablo-2/C-c'),
        Kalip::adet('Bu yayınlarınızdan en az birinde tek yazar olmalısınız', ['A.1-A.4'], 1, yazar: 'tek', donem: $DOKTORA, madde: 'Tablo-2/C-c'),
        Kalip::adet('A kategorisinden toplam en az 6 yayınınız olmalı', ['A.1-A.4'], 6, madde: 'Tablo-2/C-c'),
        Kalip::puanDan('Makale kalemlerinizden en az 60 puan', ['A-TUM'], 60, madde: 'Tablo-2/C'),
        $puanTelafili('Bildiri kalemlerinizden en az 6 puan', ['B-TUM'], 6, 200, null, 'Tablo-2/C-e'),
        Kalip::puanDan('Atıf kalemlerinizden en az 4 puan', ['E-TUM'], 4, madde: 'Tablo-2/C'),
        $puanTelafili('Araştırma projesi kalemlerinizden en az 4 puan', ['F-TUM'], 4, 200, null, 'Tablo-2/C-f'),
        Kalip::puanDan('Sanat, mimarlık ve tasarım etkinliği kalemlerinizden en az 30 puan', ['K-TUM'], 30, madde: 'Tablo-2/C'),
        Kalip::toplam(200),
    ]),
];

$esikler[] = [
    'anahtar' => 'aksaray-guzel-sanatlar-profesor',
    'aday_notu' => 'A kategorisinden en az 12 yayınınız, bunlardan 5\'i doçentlik unvanınızdan '
        .'sonra A1-A4\'ten olmalı (en az biri tek yazarlı); A kalemlerinizden en az 120 puan; '
        .'bildiri kalemlerinizden en az 10 puan (telafi ile); atıf kalemlerinizden en az 8 '
        .'puan; araştırma projesi kalemlerinizden en az 6 puan (telafi ile); sanat etkinliği '
        .'kalemlerinizden en az 35 puan ve toplamda en az 300 puan gerekiyor. Ayrıca doçentlik '
        .'sonrası yayınlarınızdan birini başlıca araştırma eseri olarak sunmalısınız.',
    'universite' => $UNIVERSITE,
    'kadro' => 'profesorluk',
    'alan' => ['guzel_sanatlar'],
    'cetvel' => $CETVEL,
    'notlar' => 'Tablo-2/C, Profesör: adet 12 (d: en az biri tek yazarlı olmak üzere 5\'i '
        .'doçentlik sonrası ve A1-A4\'ten); A puanı 120; B puanı 10 (telafi e); E puanı 8; F '
        .'puanı 6 (telafi f); K puanı 35; toplam 300. Madde 11/1-b: başlıca araştırma eseri.',
    'sart' => Kalip::ve('Profesör kadrosuna atanma', [
        Kalip::yds(65),
        Kalip::beyan('Doçentlik unvanına sahip olmak', 'Madde 11'),
        Kalip::beyan('Doçentlik unvanınızdan sonraki yayınlarınızdan birini başlıca araştırma eseri olarak sunmak', 'Madde 11/1-b'),
        Kalip::adet('Doçentlik unvanınızdan sonra A1-A4 kategorisinde en az 5 yayınınız olmalı', ['A.1-A.4'], 5, donem: $DOCENTLIK, madde: 'Tablo-2/C-d'),
        Kalip::adet('Bu yayınlarınızdan en az birinde tek yazar olmalısınız', ['A.1-A.4'], 1, yazar: 'tek', donem: $DOCENTLIK, madde: 'Tablo-2/C-d'),
        Kalip::adet('A kategorisinden toplam en az 12 yayınınız olmalı', ['A.1-A.4'], 12, madde: 'Tablo-2/C-d'),
        Kalip::puanDan('Makale kalemlerinizden en az 120 puan', ['A-TUM'], 120, madde: 'Tablo-2/C'),
        $puanTelafili('Bildiri kalemlerinizden en az 10 puan', ['B-TUM'], 10, 300, null, 'Tablo-2/C-e'),
        Kalip::puanDan('Atıf kalemlerinizden en az 8 puan', ['E-TUM'], 8, madde: 'Tablo-2/C'),
        $puanTelafili('Araştırma projesi kalemlerinizden en az 6 puan', ['F-TUM'], 6, 300, null, 'Tablo-2/C-f'),
        Kalip::puanDan('Sanat, mimarlık ve tasarım etkinliği kalemlerinizden en az 35 puan', ['K-TUM'], 35, madde: 'Tablo-2/C'),
        Kalip::toplam(300),
    ]),
];

// ══════════════════════════════════════════════════════════════════════════
// D. MİMARLIK VE TASARIM ALANI
// ══════════════════════════════════════════════════════════════════════════

$esikler[] = [
    'anahtar' => 'aksaray-mimarlik-dr',
    'aday_notu' => 'A kategorisinden en az 3 yayınınız, bunlardan en az 1\'i doktora '
        .'unvanınızdan sonra A1-A3\'ten olmalı ve başlıca yazarlı olmalı; A kalemlerinizden en '
        .'az 30 puan ve toplamda en az 100 puan (60\'ı doktora sonrası) gerekiyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi',
    'alan' => ['mimarlik'],
    'cetvel' => $CETVEL,
    'notlar' => 'Tablo-2/D, Dr. Öğr. Üyesi İlk Atanma: adet 3 (a: en az 1 A1-A3\'ten, başlıca '
        .'yazarlı, doktora sonrası); A puanı 30; toplam 100 (60\'ı doktora sonrası).',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna atanma', [
        Kalip::yds(65),
        Kalip::beyan('İlgili alanda doktora derecesine sahip olmak', 'Tablo-2/D'),
        Kalip::adet('Doktora unvanınızdan sonra A1-A3 kategorisinde en az 1 başlıca yazarlı yayınınız olmalı', ['A.1-A.3'], 1, yazar: 'baslica', donem: $DOKTORA, madde: 'Tablo-2/D-a'),
        Kalip::adet('A kategorisinden toplam en az 3 yayınınız olmalı', ['A.1-A.4'], 3, madde: 'Tablo-2/D-a'),
        Kalip::puanDan('Makale kalemlerinizden en az 30 puan', ['A-TUM'], 30, madde: 'Tablo-2/D'),
        Kalip::puanDan('Bu puanın en az 60\'ı doktora unvanınızdan sonra olmalı', ['A-TUM'], 60, $DOKTORA, madde: 'Tablo-2/D-g'),
        Kalip::toplam(100),
    ]),
];

$esikler[] = [
    'anahtar' => 'aksaray-mimarlik-dr-yeniden',
    'aday_notu' => 'Son atama tarihinizden SONRAKİ faaliyetlerinize bakılıyor: A kategorisinden '
        .'en az 2 yayınınız (en az 1\'i A1-A3\'ten), en az 20 puan; bildiri kalemlerinizden en '
        .'az 4 puan (telafi ile); proje kalemlerinizden en az 4 puan (telafi ile); toplamda '
        .'en az 60 puan gerekiyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi_yeniden',
    'alan' => ['mimarlik'],
    'cetvel' => $CETVEL,
    'notlar' => 'Tablo-2/D, Yeniden Atanma: adet 2 (b: en az 1 A1-A3\'ten); A puanı 20; B '
        .'puanı 4 (telafi e); F puanı 4 (telafi f); toplam 60.',
    'sart' => Kalip::ve('Doktor Öğretim Üyeliğine yeniden atanma', [
        Kalip::adet('Son atama tarihinizden sonra A1-A3 kategorisinde en az 1 yayınınız olmalı', ['A.1-A.3'], 1, donem: $SON_ATAMA, madde: 'Tablo-2/D-b'),
        Kalip::adet('Son atama tarihinizden sonra A kategorisinden toplam en az 2 yayınınız olmalı', ['A.1-A.4'], 2, donem: $SON_ATAMA, madde: 'Tablo-2/D-b'),
        Kalip::puanDan('Son atama tarihinizden sonra makale kalemlerinizden en az 20 puan', ['A-TUM'], 20, $SON_ATAMA, madde: 'Tablo-2/D'),
        $puanTelafili('Son atama tarihinizden sonra bildiri kalemlerinizden en az 4 puan', ['B-TUM'], 4, 60, $SON_ATAMA, 'Tablo-2/D-e'),
        $puanTelafili('Son atama tarihinizden sonra araştırma projesi kalemlerinizden en az 4 puan', ['F-TUM'], 4, 60, $SON_ATAMA, 'Tablo-2/D-f'),
        Kalip::toplam(60, $SON_ATAMA),
    ]),
];

$esikler[] = [
    'anahtar' => 'aksaray-mimarlik-docent',
    'aday_notu' => 'A kategorisinden en az 6 yayınınız, bunlardan en az 2\'si doktora '
        .'unvanınızdan sonra A1-A3\'ten olmalı (en az biri başlıca yazarlı); A kalemlerinizden '
        .'en az 60 puan; bildiri kalemlerinizden en az 6 puan (telafi ile); atıf '
        .'kalemlerinizden en az 10 puan; araştırma projesi kalemlerinizden en az 6 puan '
        .'(telafi ile); toplamda en az 200 puan gerekiyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => ['mimarlik'],
    'cetvel' => $CETVEL,
    'notlar' => 'Tablo-2/D, Doçent: adet 6 (c: en az biri başlıca yazarlı olmak üzere 2\'si '
        .'A1-A3\'ten, doktora sonrası); A puanı 60; B puanı 6 (telafi e); E puanı 10; F puanı '
        .'6 (telafi f); toplam 200.',
    'sart' => Kalip::ve('Doçent kadrosuna atanma', [
        Kalip::yds(65),
        Kalip::beyan('ÜAK doçentlik unvanına sahip olmak', 'Madde 10'),
        Kalip::adet('Doktora unvanınızdan sonra A1-A3 kategorisinde en az 2 yayınınız olmalı', ['A.1-A.3'], 2, donem: $DOKTORA, madde: 'Tablo-2/D-c'),
        Kalip::adet('Bu yayınlarınızdan en az birinde başlıca yazar olmalısınız', ['A.1-A.3'], 1, yazar: 'baslica', donem: $DOKTORA, madde: 'Tablo-2/D-c'),
        Kalip::adet('A kategorisinden toplam en az 6 yayınınız olmalı', ['A.1-A.4'], 6, madde: 'Tablo-2/D-c'),
        Kalip::puanDan('Makale kalemlerinizden en az 60 puan', ['A-TUM'], 60, madde: 'Tablo-2/D'),
        $puanTelafili('Bildiri kalemlerinizden en az 6 puan', ['B-TUM'], 6, 200, null, 'Tablo-2/D-e'),
        Kalip::puanDan('Atıf kalemlerinizden en az 10 puan', ['E-TUM'], 10, madde: 'Tablo-2/D'),
        $puanTelafili('Araştırma projesi kalemlerinizden en az 6 puan', ['F-TUM'], 6, 200, null, 'Tablo-2/D-f'),
        Kalip::toplam(200),
    ]),
];

$esikler[] = [
    'anahtar' => 'aksaray-mimarlik-profesor',
    'aday_notu' => 'A kategorisinden en az 12 yayınınız, bunlardan 5\'i doçentlik unvanınızdan '
        .'sonra A1-A3\'ten olmalı (en az biri başlıca yazarlı); A kalemlerinizden en az 120 '
        .'puan; bildiri kalemlerinizden en az 10 puan (telafi ile); atıf kalemlerinizden en '
        .'az 15 puan; araştırma projesi kalemlerinizden en az 10 puan (telafi ile); toplamda '
        .'en az 300 puan gerekiyor. Ayrıca doçentlik sonrası yayınlarınızdan birini başlıca '
        .'araştırma eseri olarak sunmalısınız.',
    'universite' => $UNIVERSITE,
    'kadro' => 'profesorluk',
    'alan' => ['mimarlik'],
    'cetvel' => $CETVEL,
    'notlar' => 'Tablo-2/D, Profesör: adet 12 (d: en az biri başlıca yazarlı olmak üzere 5\'i '
        .'doçentlik sonrası ve A1-A3\'ten); A puanı 120; B puanı 10 (telafi e); E puanı 15; F '
        .'puanı 10 (telafi f); toplam 300. Madde 11/1-b: başlıca araştırma eseri.',
    'sart' => Kalip::ve('Profesör kadrosuna atanma', [
        Kalip::yds(65),
        Kalip::beyan('Doçentlik unvanına sahip olmak', 'Madde 11'),
        Kalip::beyan('Doçentlik unvanınızdan sonraki yayınlarınızdan birini başlıca araştırma eseri olarak sunmak', 'Madde 11/1-b'),
        Kalip::adet('Doçentlik unvanınızdan sonra A1-A3 kategorisinde en az 5 yayınınız olmalı', ['A.1-A.3'], 5, donem: $DOCENTLIK, madde: 'Tablo-2/D-d'),
        Kalip::adet('Bu yayınlarınızdan en az birinde başlıca yazar olmalısınız', ['A.1-A.3'], 1, yazar: 'baslica', donem: $DOCENTLIK, madde: 'Tablo-2/D-d'),
        Kalip::adet('A kategorisinden toplam en az 12 yayınınız olmalı', ['A.1-A.4'], 12, madde: 'Tablo-2/D-d'),
        Kalip::puanDan('Makale kalemlerinizden en az 120 puan', ['A-TUM'], 120, madde: 'Tablo-2/D'),
        $puanTelafili('Bildiri kalemlerinizden en az 10 puan', ['B-TUM'], 10, 300, null, 'Tablo-2/D-e'),
        Kalip::puanDan('Atıf kalemlerinizden en az 15 puan', ['E-TUM'], 15, madde: 'Tablo-2/D'),
        $puanTelafili('Araştırma projesi kalemlerinizden en az 10 puan', ['F-TUM'], 10, 300, null, 'Tablo-2/D-f'),
        Kalip::toplam(300),
    ]),
];

// ══════════════════════════════════════════════════════════════════════════
// E. SAĞLIK BİLİMLERİ ALANI
// ══════════════════════════════════════════════════════════════════════════

$esikler[] = [
    'anahtar' => 'aksaray-saglik-dr',
    'aday_notu' => 'A kategorisinden en az 3 yayınınız, bunlardan 2\'si doktora/uzmanlık '
        .'unvanınızdan sonra A1\'den olmalı (en az biri başlıca yazarlı); A kalemlerinizden en '
        .'az 30 puan ve toplamda en az 100 puan (60\'ı doktora/uzmanlık sonrası) gerekiyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi',
    'alan' => ['saglik'],
    'cetvel' => $CETVEL,
    'notlar' => 'Tablo-2/E, Dr. Öğr. Üyesi İlk Atanma: adet 3 (a: 1\'i A1-A4\'ten; en az biri '
        .'başlıca yazarlı olmak üzere diğer 2\'si A1\'den, doktora/uzmanlık sonrası); A puanı '
        .'30; toplam 100 (60\'ı doktora/uzmanlık sonrası).',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna atanma', [
        Kalip::yds(65),
        Kalip::beyan('İlgili alanda doktora veya uzmanlık derecesine sahip olmak', 'Tablo-2/E'),
        Kalip::adet('Doktora/uzmanlık unvanınızdan sonra A1 kategorisinde en az 2 yayınınız olmalı', ['A.1-TUM'], 2, donem: $DOKTORA, madde: 'Tablo-2/E-a'),
        Kalip::adet('Bu A1 yayınlarınızdan en az birinde başlıca yazar olmalısınız', ['A.1-TUM'], 1, yazar: 'baslica', donem: $DOKTORA, madde: 'Tablo-2/E-a'),
        Kalip::adet('A kategorisinden toplam en az 3 yayınınız olmalı', ['A.1-A.4'], 3, madde: 'Tablo-2/E-a'),
        Kalip::puanDan('Makale kalemlerinizden en az 30 puan', ['A-TUM'], 30, madde: 'Tablo-2/E'),
        Kalip::puanDan('Bu puanın en az 60\'ı doktora/uzmanlık unvanınızdan sonra olmalı', ['A-TUM'], 60, $DOKTORA, madde: 'Tablo-2/E-g'),
        Kalip::toplam(100),
    ]),
];

$esikler[] = [
    'anahtar' => 'aksaray-saglik-dr-yeniden',
    'aday_notu' => 'Son atama tarihinizden SONRAKİ faaliyetlerinize bakılıyor: A kategorisinden '
        .'en az 3 yayınınız (en az 1\'i A1\'de başlıca yazarlı olmalı), en az 20 puan; bildiri '
        .'kalemlerinizden en az 4 puan (telafi ile); proje kalemlerinizden en az 2 puan (telafi '
        .'ile); toplamda en az 60 puan gerekiyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi_yeniden',
    'alan' => ['saglik'],
    'cetvel' => $CETVEL,
    'notlar' => 'Tablo-2/E, Yeniden Atanma: adet 3 (b: en az 1\'i A1\'de başlıca yazarlı; '
        .'diğerleri A1-A3\'ten); A puanı 20; B puanı 4 (telafi e); F puanı 2 (telafi f); '
        .'toplam 60.',
    'sart' => Kalip::ve('Doktor Öğretim Üyeliğine yeniden atanma', [
        Kalip::adet('Son atama tarihinizden sonra A1 kategorisinde en az 1 başlıca yazarlı yayınınız olmalı', ['A.1-TUM'], 1, yazar: 'baslica', donem: $SON_ATAMA, madde: 'Tablo-2/E-b'),
        Kalip::adet('Son atama tarihinizden sonra A1-A3 kategorisinde toplam en az 3 yayınınız olmalı', ['A.1-A.3'], 3, donem: $SON_ATAMA, madde: 'Tablo-2/E-b'),
        Kalip::puanDan('Son atama tarihinizden sonra makale kalemlerinizden en az 20 puan', ['A-TUM'], 20, $SON_ATAMA, madde: 'Tablo-2/E'),
        $puanTelafili('Son atama tarihinizden sonra bildiri kalemlerinizden en az 4 puan', ['B-TUM'], 4, 60, $SON_ATAMA, 'Tablo-2/E-e'),
        $puanTelafili('Son atama tarihinizden sonra araştırma projesi kalemlerinizden en az 2 puan', ['F-TUM'], 2, 60, $SON_ATAMA, 'Tablo-2/E-f'),
        Kalip::toplam(60, $SON_ATAMA),
    ]),
];

$esikler[] = [
    'anahtar' => 'aksaray-saglik-docent',
    'aday_notu' => 'A kategorisinden en az 6 yayınınız, bunlardan en az 3\'ü doktora/uzmanlık '
        .'unvanınızdan sonra A1\'den olmalı (en az biri başlıca yazarlı); A kalemlerinizden en '
        .'az 60 puan; bildiri kalemlerinizden en az 7 puan (telafi ile); atıf kalemlerinizden '
        .'en az 10 puan; araştırma projesi kalemlerinizden en az 4 puan (telafi ile); '
        .'toplamda en az 200 puan gerekiyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => ['saglik'],
    'cetvel' => $CETVEL,
    'notlar' => 'Tablo-2/E, Doçent: adet 6 (c: en az biri başlıca yazarlı olmak üzere 3\'ü '
        .'A1\'den, doktora/uzmanlık sonrası); A puanı 60; B puanı 7 (telafi e); E puanı 10; F '
        .'puanı 4 (telafi f); toplam 200.',
    'sart' => Kalip::ve('Doçent kadrosuna atanma', [
        Kalip::yds(65),
        Kalip::beyan('ÜAK doçentlik unvanına sahip olmak', 'Madde 10'),
        Kalip::adet('Doktora/uzmanlık unvanınızdan sonra A1 kategorisinde en az 3 yayınınız olmalı', ['A.1-TUM'], 3, donem: $DOKTORA, madde: 'Tablo-2/E-c'),
        Kalip::adet('Bu A1 yayınlarınızdan en az birinde başlıca yazar olmalısınız', ['A.1-TUM'], 1, yazar: 'baslica', donem: $DOKTORA, madde: 'Tablo-2/E-c'),
        Kalip::adet('A kategorisinden toplam en az 6 yayınınız olmalı', ['A.1-A.4'], 6, madde: 'Tablo-2/E-c'),
        Kalip::puanDan('Makale kalemlerinizden en az 60 puan', ['A-TUM'], 60, madde: 'Tablo-2/E'),
        $puanTelafili('Bildiri kalemlerinizden en az 7 puan', ['B-TUM'], 7, 200, null, 'Tablo-2/E-e'),
        Kalip::puanDan('Atıf kalemlerinizden en az 10 puan', ['E-TUM'], 10, madde: 'Tablo-2/E'),
        $puanTelafili('Araştırma projesi kalemlerinizden en az 4 puan', ['F-TUM'], 4, 200, null, 'Tablo-2/E-f'),
        Kalip::toplam(200),
    ]),
];

$esikler[] = [
    'anahtar' => 'aksaray-saglik-profesor',
    'aday_notu' => 'A kategorisinden en az 12 yayınınız, bunlardan 5\'i doçentlik unvanınızdan '
        .'sonra olmalı ve en az 2\'si başlıca yazarlı A1\'den olmalı; A kalemlerinizden en az '
        .'120 puan; bildiri kalemlerinizden en az 10 puan (telafi ile); atıf kalemlerinizden '
        .'en az 15 puan; araştırma projesi kalemlerinizden en az 6 puan (telafi ile); '
        .'toplamda en az 300 puan gerekiyor. Ayrıca doçentlik sonrası yayınlarınızdan birini '
        .'başlıca araştırma eseri olarak sunmalısınız.',
    'universite' => $UNIVERSITE,
    'kadro' => 'profesorluk',
    'alan' => ['saglik'],
    'cetvel' => $CETVEL,
    'notlar' => 'Tablo-2/E, Profesör: adet 12 (d: beşi doçentlik sonrası, en az 2\'si başlıca '
        .'yazarlı A1\'den); A puanı 120; B puanı 10 (telafi e); E puanı 15; F puanı 6 (telafi '
        .'f); toplam 300. Madde 11/1-b: başlıca araştırma eseri.',
    'sart' => Kalip::ve('Profesör kadrosuna atanma', [
        Kalip::yds(65),
        Kalip::beyan('Doçentlik unvanına sahip olmak', 'Madde 11'),
        Kalip::beyan('Doçentlik unvanınızdan sonraki yayınlarınızdan birini başlıca araştırma eseri olarak sunmak', 'Madde 11/1-b'),
        Kalip::adet('A1 kategorisinde doçentlik unvanınızdan sonra en az 2 başlıca yazarlı yayınınız olmalı', ['A.1-TUM'], 2, yazar: 'baslica', donem: $DOCENTLIK, madde: 'Tablo-2/E-d'),
        Kalip::adet('Doçentlik unvanınızdan sonra A kategorisinden toplam en az 5 yayınınız olmalı', ['A.1-A.4'], 5, donem: $DOCENTLIK, madde: 'Tablo-2/E-d'),
        Kalip::adet('A kategorisinden toplam en az 12 yayınınız olmalı', ['A.1-A.4'], 12, madde: 'Tablo-2/E-d'),
        Kalip::puanDan('Makale kalemlerinizden en az 120 puan', ['A-TUM'], 120, madde: 'Tablo-2/E'),
        $puanTelafili('Bildiri kalemlerinizden en az 10 puan', ['B-TUM'], 10, 300, null, 'Tablo-2/E-e'),
        Kalip::puanDan('Atıf kalemlerinizden en az 15 puan', ['E-TUM'], 15, madde: 'Tablo-2/E'),
        $puanTelafili('Araştırma projesi kalemlerinizden en az 6 puan', ['F-TUM'], 6, 300, null, 'Tablo-2/E-f'),
        Kalip::toplam(300),
    ]),
];

// ══════════════════════════════════════════════════════════════════════════
// F. SOSYAL, BEŞERİ VE İDARİ BİLİMLER ALANI
// ══════════════════════════════════════════════════════════════════════════

$esikler[] = [
    'anahtar' => 'aksaray-sosyal-dr',
    'aday_notu' => 'A kategorisinden en az 3 yayınınız, bunlardan en az 2\'si doktora '
        .'unvanınızdan sonra A1-A4\'ten olmalı (ikisi de tek yazarlı); A kalemlerinizden en az '
        .'35 puan; bildiri kalemlerinizden en az 3 puan (telafi ile) ve toplamda en az 100 puan (60\'ı '
        .'doktora sonrası) gerekiyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi',
    'alan' => ['sosyal', 'hukuk', 'filoloji', 'ilahiyat'],
    'cetvel' => $CETVEL,
    'notlar' => 'Tablo-2/F, Dr. Öğr. Üyesi İlk Atanma: adet 3 (a: ikisi tek yazarlı olmak '
        .'üzere en az 2\'si A1-A4\'ten, doktora sonrası); A puanı 35; B puanı 3 (telafi e); toplam 100 '
        .'(60\'ı doktora sonrası).',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna atanma', [
        Kalip::yds(65),
        Kalip::beyan('İlgili alanda doktora derecesine sahip olmak', 'Tablo-2/F'),
        Kalip::adet('Doktora unvanınızdan sonra A1-A4 kategorisinde en az 2 tek yazarlı yayınınız olmalı', ['A.1-A.4'], 2, yazar: 'tek', donem: $DOKTORA, madde: 'Tablo-2/F-a'),
        Kalip::adet('A kategorisinden toplam en az 3 yayınınız olmalı', ['A.1-A.4'], 3, madde: 'Tablo-2/F-a'),
        Kalip::puanDan('Makale kalemlerinizden en az 35 puan', ['A-TUM'], 35, madde: 'Tablo-2/F'),
        Kalip::puanDan('Bu puanın en az 60\'ı doktora unvanınızdan sonra olmalı', ['A-TUM'], 60, $DOKTORA, madde: 'Tablo-2/F-h'),
        $puanTelafili('Bildiri kalemlerinizden en az 3 puan', ['B-TUM'], 3, 100, null, 'Tablo-2/F-e'),
        Kalip::toplam(100),
    ]),
];

$esikler[] = [
    'anahtar' => 'aksaray-sosyal-dr-yeniden',
    'aday_notu' => 'Son atama tarihinizden SONRAKİ faaliyetlerinize bakılıyor: A kategorisinden '
        .'en az 2 yayınınız (en az 1\'i A1-A4\'te tek yazarlı olmalı), en az 20 puan; bildiri '
        .'kalemlerinizden en az 2 puan (telafi ile); kitap kalemlerinizden en az 4 puan; araştırma projesi '
        .'kalemlerinizden en az 2 puan (telafi ile) ve toplamda en az 60 puan gerekiyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi_yeniden',
    'alan' => ['sosyal', 'hukuk', 'filoloji', 'ilahiyat'],
    'cetvel' => $CETVEL,
    'notlar' => 'Tablo-2/F, Yeniden Atanma: adet 2 (b: tek yazar olmak üzere en az 1\'i '
        .'A1-A4\'ten); A puanı 20; B puanı 2 (telafi e); C puanı 4 (f: tezden üretilmemiş olmalı); F '
        .'puanı 2 (telafi g); toplam 60.',
    'sart' => Kalip::ve('Doktor Öğretim Üyeliğine yeniden atanma', [
        Kalip::adet('Son atama tarihinizden sonra A1-A4 kategorisinde en az 1 tek yazarlı yayınınız olmalı', ['A.1-A.4'], 1, yazar: 'tek', donem: $SON_ATAMA, madde: 'Tablo-2/F-b'),
        Kalip::adet('Son atama tarihinizden sonra A kategorisinden toplam en az 2 yayınınız olmalı', ['A.1-A.4'], 2, donem: $SON_ATAMA, madde: 'Tablo-2/F-b'),
        Kalip::puanDan('Son atama tarihinizden sonra makale kalemlerinizden en az 20 puan', ['A-TUM'], 20, $SON_ATAMA, madde: 'Tablo-2/F'),
        $puanTelafili('Son atama tarihinizden sonra bildiri kalemlerinizden en az 2 puan', ['B-TUM'], 2, 60, $SON_ATAMA, 'Tablo-2/F-e'),
        Kalip::puanDan('Son atama tarihinizden sonra kitap kalemlerinizden en az 4 puan', ['C-TUM'], 4, $SON_ATAMA, madde: 'Tablo-2/F'),
        $puanTelafili('Son atama tarihinizden sonra araştırma projesi kalemlerinizden en az 2 puan', ['F-TUM'], 2, 60, $SON_ATAMA, 'Tablo-2/F-g'),
        Kalip::toplam(60, $SON_ATAMA),
    ]),
];

$esikler[] = [
    'anahtar' => 'aksaray-sosyal-docent',
    'aday_notu' => 'A kategorisinden en az 6 yayınınız, bunlardan en az 4\'ü doktora '
        .'unvanınızdan sonra A1-A4\'ten olmalı (en az 3\'ü tek yazarlı); A kalemlerinizden en '
        .'az 60 puan; bildiri kalemlerinizden en az 8 puan (telafi ile); kitap kalemlerinizden '
        .'en az 9 puan; atıf kalemlerinizden en az 10 puan; araştırma projesi kalemlerinizden '
        .'en az 4 puan (telafi ile) ve toplamda en az 200 puan gerekiyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => ['sosyal', 'hukuk', 'filoloji', 'ilahiyat'],
    'cetvel' => $CETVEL,
    'notlar' => 'Tablo-2/F, Doçent: adet 6 (c: en az 3\'ü tek yazarlı olmak üzere 4\'ü '
        .'A1-A4\'ten, doktora sonrası); A puanı 60; B puanı 8 (telafi e); C puanı 9; E puanı '
        .'10; F puanı 4 (telafi g); toplam 200.',
    'sart' => Kalip::ve('Doçent kadrosuna atanma', [
        Kalip::yds(65),
        Kalip::beyan('ÜAK doçentlik unvanına sahip olmak', 'Madde 10'),
        Kalip::adet('Doktora unvanınızdan sonra A1-A4 kategorisinde en az 3 tek yazarlı yayınınız olmalı', ['A.1-A.4'], 3, yazar: 'tek', donem: $DOKTORA, madde: 'Tablo-2/F-c'),
        Kalip::adet('Doktora unvanınızdan sonra A kategorisinden toplam en az 4 yayınınız olmalı', ['A.1-A.4'], 4, donem: $DOKTORA, madde: 'Tablo-2/F-c'),
        Kalip::adet('A kategorisinden toplam en az 6 yayınınız olmalı', ['A.1-A.4'], 6, madde: 'Tablo-2/F-c'),
        Kalip::puanDan('Makale kalemlerinizden en az 60 puan', ['A-TUM'], 60, madde: 'Tablo-2/F'),
        $puanTelafili('Bildiri kalemlerinizden en az 8 puan', ['B-TUM'], 8, 200, null, 'Tablo-2/F-e'),
        Kalip::puanDan('Kitap kalemlerinizden en az 9 puan', ['C-TUM'], 9, madde: 'Tablo-2/F'),
        Kalip::puanDan('Atıf kalemlerinizden en az 10 puan', ['E-TUM'], 10, madde: 'Tablo-2/F'),
        $puanTelafili('Araştırma projesi kalemlerinizden en az 4 puan', ['F-TUM'], 4, 200, null, 'Tablo-2/F-g'),
        Kalip::toplam(200),
    ]),
];

$esikler[] = [
    'anahtar' => 'aksaray-sosyal-profesor',
    'aday_notu' => 'A kategorisinden en az 12 yayınınız, bunlardan 5\'i doçentlik unvanınızdan '
        .'sonra olmalı ve en az 2\'si tek yazarlı olmalı; A kalemlerinizden en az 120 puan; '
        .'bildiri kalemlerinizden en az 12 puan (telafi ile); kitap kalemlerinizden en az 12 '
        .'puan; atıf kalemlerinizden en az 15 puan; araştırma projesi kalemlerinizden en az 6 '
        .'puan (telafi ile) ve toplamda en az 300 puan gerekiyor. Ayrıca doçentlik sonrası '
        .'yayınlarınızdan birini başlıca araştırma eseri olarak sunmalısınız.',
    'universite' => $UNIVERSITE,
    'kadro' => 'profesorluk',
    'alan' => ['sosyal', 'hukuk', 'filoloji', 'ilahiyat'],
    'cetvel' => $CETVEL,
    'notlar' => 'Tablo-2/F, Profesör: adet 12 (d: beşi doçentlik sonrası, en az 2\'si tek '
        .'yazarlı); A puanı 120; B puanı 12 (telafi e); C puanı 12; E puanı 15; F puanı 6 '
        .'(telafi g); toplam 300. Madde 11/1-b: başlıca araştırma eseri.',
    'sart' => Kalip::ve('Profesör kadrosuna atanma', [
        Kalip::yds(65),
        Kalip::beyan('Doçentlik unvanına sahip olmak', 'Madde 11'),
        Kalip::beyan('Doçentlik unvanınızdan sonraki yayınlarınızdan birini başlıca araştırma eseri olarak sunmak', 'Madde 11/1-b'),
        Kalip::adet('Doçentlik unvanınızdan sonra A1-A4 kategorisinde en az 2 tek yazarlı yayınınız olmalı', ['A.1-A.4'], 2, yazar: 'tek', donem: $DOCENTLIK, madde: 'Tablo-2/F-d'),
        Kalip::adet('Doçentlik unvanınızdan sonra A kategorisinden toplam en az 5 yayınınız olmalı', ['A.1-A.4'], 5, donem: $DOCENTLIK, madde: 'Tablo-2/F-d'),
        Kalip::adet('A kategorisinden toplam en az 12 yayınınız olmalı', ['A.1-A.4'], 12, madde: 'Tablo-2/F-d'),
        Kalip::puanDan('Makale kalemlerinizden en az 120 puan', ['A-TUM'], 120, madde: 'Tablo-2/F'),
        $puanTelafili('Bildiri kalemlerinizden en az 12 puan', ['B-TUM'], 12, 300, null, 'Tablo-2/F-e'),
        Kalip::puanDan('Kitap kalemlerinizden en az 12 puan', ['C-TUM'], 12, madde: 'Tablo-2/F'),
        Kalip::puanDan('Atıf kalemlerinizden en az 15 puan', ['E-TUM'], 15, madde: 'Tablo-2/F'),
        $puanTelafili('Araştırma projesi kalemlerinizden en az 6 puan', ['F-TUM'], 6, 300, null, 'Tablo-2/F-g'),
        Kalip::toplam(300),
    ]),
];

// ══════════════════════════════════════════════════════════════════════════
// G. SPOR BİLİMLERİ
// ══════════════════════════════════════════════════════════════════════════

$esikler[] = [
    'anahtar' => 'aksaray-spor-dr',
    'aday_notu' => 'A kategorisinden en az 3 yayınınız, bunlardan en az 1\'i doktora '
        .'unvanınızdan sonra A1\'den olmalı ve başlıca yazarlı olmalı; A kalemlerinizden en '
        .'az 30 puan; bildiri kalemlerinizden en az 4 puan (telafi ile) ve toplamda en az 100 puan (60\'ı '
        .'doktora sonrası) gerekiyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi',
    'alan' => ['spor'],
    'cetvel' => $CETVEL,
    'notlar' => 'Tablo-2/G, Dr. Öğr. Üyesi İlk Atanma (a bendi 24.09.2025/2025-25-01 ile '
        .'değiştirildi; PDF\'teki tablo değişiklik sonrası hâli): adet 3 (a: en az 1 A1\'den, başlıca '
        .'yazarlı, doktora sonrası); A puanı 30; B puanı 4 (telafi e); toplam 100 (60\'ı doktora sonrası).',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna atanma', [
        Kalip::yds(65),
        Kalip::beyan('İlgili alanda doktora derecesine sahip olmak', 'Tablo-2/G'),
        Kalip::adet('Doktora unvanınızdan sonra A1 kategorisinde en az 1 başlıca yazarlı yayınınız olmalı', ['A.1-TUM'], 1, yazar: 'baslica', donem: $DOKTORA, madde: 'Tablo-2/G-a'),
        Kalip::adet('A kategorisinden toplam en az 3 yayınınız olmalı', ['A.1-A.4'], 3, madde: 'Tablo-2/G-a'),
        Kalip::puanDan('Makale kalemlerinizden en az 30 puan', ['A-TUM'], 30, madde: 'Tablo-2/G'),
        Kalip::puanDan('Bu puanın en az 60\'ı doktora unvanınızdan sonra olmalı', ['A-TUM'], 60, $DOKTORA, madde: 'Tablo-2/G-h'),
        $puanTelafili('Bildiri kalemlerinizden en az 4 puan', ['B-TUM'], 4, 100, null, 'Tablo-2/G-e'),
        Kalip::toplam(100),
    ]),
];

$esikler[] = [
    'anahtar' => 'aksaray-spor-dr-yeniden',
    'aday_notu' => 'Son atama tarihinizden SONRAKİ faaliyetlerinize bakılıyor: A kategorisinden '
        .'en az 2 yayınınız (en az 1\'i A1-A3\'ten), en az 20 puan; bildiri kalemlerinizden en '
        .'az 3 puan (telafi ile); araştırma projesi kalemlerinizden en az 4 puan (telafi ile) ve toplamda '
        .'en az 60 puan gerekiyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi_yeniden',
    'alan' => ['spor'],
    'cetvel' => $CETVEL,
    'notlar' => 'Tablo-2/G, Yeniden Atanma: adet 2 (b: en az 1 A1-A3\'ten); A puanı 20; B '
        .'puanı 3 (telafi e); F puanı 4 (telafi g); toplam 60.',
    'sart' => Kalip::ve('Doktor Öğretim Üyeliğine yeniden atanma', [
        Kalip::adet('Son atama tarihinizden sonra A1-A3 kategorisinde en az 1 yayınınız olmalı', ['A.1-A.3'], 1, donem: $SON_ATAMA, madde: 'Tablo-2/G-b'),
        Kalip::adet('Son atama tarihinizden sonra A kategorisinden toplam en az 2 yayınınız olmalı', ['A.1-A.4'], 2, donem: $SON_ATAMA, madde: 'Tablo-2/G-b'),
        Kalip::puanDan('Son atama tarihinizden sonra makale kalemlerinizden en az 20 puan', ['A-TUM'], 20, $SON_ATAMA, madde: 'Tablo-2/G'),
        $puanTelafili('Son atama tarihinizden sonra bildiri kalemlerinizden en az 3 puan', ['B-TUM'], 3, 60, $SON_ATAMA, 'Tablo-2/G-e'),
        $puanTelafili('Son atama tarihinizden sonra araştırma projesi kalemlerinizden en az 4 puan', ['F-TUM'], 4, 60, $SON_ATAMA, 'Tablo-2/G-g'),
        Kalip::toplam(60, $SON_ATAMA),
    ]),
];

$esikler[] = [
    'anahtar' => 'aksaray-spor-docent',
    'aday_notu' => 'A kategorisinden en az 6 yayınınız, bunlardan en az 3\'ü doktora '
        .'unvanınızdan sonra A1\'den olmalı (en az biri başlıca yazarlı); A kalemlerinizden en '
        .'az 60 puan; bildiri kalemlerinizden en az 6 puan (telafi ile); kitap kalemlerinizden '
        .'en az 9 puan; atıf kalemlerinizden en az 10 puan; araştırma projesi kalemlerinizden '
        .'en az 6 puan (telafi ile) ve toplamda en az 200 puan gerekiyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => ['spor'],
    'cetvel' => $CETVEL,
    'notlar' => 'Tablo-2/G, Doçent: adet 6 (c: en az biri başlıca yazarlı olmak üzere 3\'ü '
        .'A1\'den, doktora sonrası); A puanı 60; B puanı 6 (telafi e); C puanı 9; E puanı 10; '
        .'F puanı 6 (telafi g); toplam 200.',
    'sart' => Kalip::ve('Doçent kadrosuna atanma', [
        Kalip::yds(65),
        Kalip::beyan('ÜAK doçentlik unvanına sahip olmak', 'Madde 10'),
        Kalip::adet('Doktora unvanınızdan sonra A1 kategorisinde en az 3 yayınınız olmalı', ['A.1-TUM'], 3, donem: $DOKTORA, madde: 'Tablo-2/G-c'),
        Kalip::adet('Bu A1 yayınlarınızdan en az birinde başlıca yazar olmalısınız', ['A.1-TUM'], 1, yazar: 'baslica', donem: $DOKTORA, madde: 'Tablo-2/G-c'),
        Kalip::adet('A kategorisinden toplam en az 6 yayınınız olmalı', ['A.1-A.4'], 6, madde: 'Tablo-2/G-c'),
        Kalip::puanDan('Makale kalemlerinizden en az 60 puan', ['A-TUM'], 60, madde: 'Tablo-2/G'),
        $puanTelafili('Bildiri kalemlerinizden en az 6 puan', ['B-TUM'], 6, 200, null, 'Tablo-2/G-e'),
        Kalip::puanDan('Kitap kalemlerinizden en az 9 puan', ['C-TUM'], 9, madde: 'Tablo-2/G'),
        Kalip::puanDan('Atıf kalemlerinizden en az 10 puan', ['E-TUM'], 10, madde: 'Tablo-2/G'),
        $puanTelafili('Araştırma projesi kalemlerinizden en az 6 puan', ['F-TUM'], 6, 200, null, 'Tablo-2/G-g'),
        Kalip::toplam(200),
    ]),
];

$esikler[] = [
    'anahtar' => 'aksaray-spor-profesor',
    'aday_notu' => 'Doçentlik unvanınızdan SONRAKİ çalışmalarınıza bakılıyor: A1 kategorisinde '
        .'en az 2 yayınınız olmalı (en az biri başlıca yazarlı); A1-A4 kategorisinde toplam en az 4 '
        .'yayınınız olmalı; A kategorisinden toplam en az 12 yayınınız, A kalemlerinizden en '
        .'az 120 puan; bildiri kalemlerinizden en az 10 puan (telafi ile); kitap '
        .'kalemlerinizden en az 12 puan; atıf kalemlerinizden en az 15 puan; araştırma '
        .'projesi kalemlerinizden en az 10 puan (telafi ile) ve toplamda en az 300 puan '
        .'gerekiyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'profesorluk',
    'alan' => ['spor'],
    'cetvel' => $CETVEL,
    'notlar' => 'Tablo-2/G, Profesör: doçentlik unvanı sonrası A1\'de en az 2 yayın (en az biri '
        .'başlıca yazarlı); A1-A4\'te en az 4 yayın; genel adet 12; A/B/C/E/F puan tabanları '
        .'120/10 (telafi e)/12/15/10 (telafi g); toplam 300. Madde 11/1-b: başlıca araştırma eseri.',
    'sart' => Kalip::ve('Profesör kadrosuna atanma', [
        Kalip::yds(65),
        Kalip::beyan('Doçentlik unvanına sahip olmak', 'Madde 11'),
        Kalip::beyan('Doçentlik unvanınızdan sonraki yayınlarınızdan birini başlıca araştırma eseri olarak sunmak', 'Madde 11/1-b'),
        Kalip::adet('Doçentlik unvanınızdan sonra A1 kategorisinde en az 2 yayınınız olmalı', ['A.1-TUM'], 2, donem: $DOCENTLIK, madde: 'Tablo-2/G-d'),
        Kalip::adet('Bu A1 yayınlarınızdan en az birinde başlıca yazar olmalısınız', ['A.1-TUM'], 1, yazar: 'baslica', donem: $DOCENTLIK, madde: 'Tablo-2/G-d'),
        Kalip::adet('Doçentlik unvanınızdan sonra A1-A4 kategorisinde toplam en az 4 yayınınız olmalı', ['A.1-A.4'], 4, donem: $DOCENTLIK, madde: 'Tablo-2/G-d'),
        Kalip::adet('A kategorisinden toplam en az 12 yayınınız olmalı', ['A.1-A.4'], 12, madde: 'Tablo-2/G-d'),
        Kalip::puanDan('Makale kalemlerinizden en az 120 puan', ['A-TUM'], 120, madde: 'Tablo-2/G'),
        $puanTelafili('Bildiri kalemlerinizden en az 10 puan', ['B-TUM'], 10, 300, null, 'Tablo-2/G-e'),
        Kalip::puanDan('Kitap kalemlerinizden en az 12 puan', ['C-TUM'], 12, madde: 'Tablo-2/G'),
        Kalip::puanDan('Atıf kalemlerinizden en az 15 puan', ['E-TUM'], 15, madde: 'Tablo-2/G'),
        $puanTelafili('Araştırma projesi kalemlerinizden en az 10 puan', ['F-TUM'], 10, 300, null, 'Tablo-2/G-g'),
        Kalip::toplam(300),
    ]),
];

return $esikler;
