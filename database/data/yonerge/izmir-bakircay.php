<?php

use App\Services\Scoring\Sart\Kalip;

/**
 * İZMİR BAKIRÇAY ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma
 * Yönergesi
 * Kaynak: pdf/1774860669632.izmir-bakircay-kriter-30032026.pdf
 *
 * Cetvel: cetvel/izmir-bakircay-2026.php
 *
 * ── EŞİKLERİN YAPISI ──
 * Puan barajı yalnızca doktor öğretim üyeliğinde var (ilk atamada ve
 * yeniden atamada 40 puan) ve buna belirli tablo bölümlerinden gelmesi
 * gereken eser SAYISI koşulu eşlik ediyor. Doçentlikte (MADDE 12) doçent
 * unvanı ile iki yarıyıl ders verme; profesörlükte (MADDE 11) ÜAK
 * doçentlik başvuru şartlarının doçentlik sonrasında yeni çalışmalarla
 * yeniden sağlanması aranıyor.
 *
 * ── YORUM KARARLARI (§0) ──
 *   MADDE 13'ün eser koşulları iki alan grubuna ayrılıyor. "Sağlık
 *       Yönetimi Bilim Alanı" ikinci (daha geniş) gruba konmuş ama
 *       profilde alt bilim alanı yok; Sağlık Bilimleri temel alanı §0
 *       gereği daha DAR olan birinci gruba bağlandı.
 *   Tablonun 3. bölümü (lisansüstü tezlerden üretilmiş yayınlar) cetvele
 *       girilemediği için MADDE 13/1-a'nın "1 (a,b) veya 3 (a)" ve
 *       13/1-b'nin "3 (a,b,c)" kolları yalnız 1 ve 2. bölüm üzerinden
 *       değerlendiriliyor.
 *   MADDE 14/6'nın "koşulların ve toplam puanın yarısını sağlayan aday bir
 *       defaya mahsus yeniden atanabilir" istisnası ile MADDE 14/7'nin
 *       askerlik, doğum ve sağlık raporu süre eklemesi yazılmadı.
 *   MADDE 11'in profesörlük koşulu ÜAK'ın doçentlik başvuru şartlarına
 *       atıf yapıyor; şartlar temel alana ve başvuru dönemine göre
 *       değiştiği için koşul `hesaplanamiyor` düğümü olarak duruyor ve
 *       profesörlük sonucu "belirsiz" dönüyor.
 *   İlahiyat, Spor Bilimleri ve Güzel Sanatlar temel alanları MADDE 13 ve
 *       14'ün alan gruplarında geçmiyor (üniversitede bu birimler yok);
 *       bu alanlarda doktor öğretim üyeliği eşiği yazılmadı.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   MADDE 10'un yabancı dil koşulu ÜAK doçentlik ölçütlerine atıf yapıyor
 *       ve temel alana göre değişiyor; sayısal bir eşik verilmediği için
 *       yazılmadı.
 *   MADDE 15'in "yayımlanmış ya da DOI numarası almış olma" şartı ile
 *       MADDE 5-9'un başvuru, komisyon ve jüri usulleri.
 */
$FEN = ['fen', 'mimarlik', 'muhendislik', 'saglik', 'ziraat'];
$SOSYAL = ['egitim', 'filoloji', 'hukuk', 'sosyal'];
$TUM = [...$FEN, ...$SOSYAL];

$PROF_NOTU = 'Profesörlükte İzmir Bakırçay puan barajı koymuyor; MADDE 11, doçentlik '
    .'unvanını aldıktan sonraki YENİ çalışmalarla ÜAK\'ın doçentlik başvuru şartlarını '
    .'yeniden sağlamanızı istiyor. Bu şartlar temel alana ve başvuru dönemine göre '
    .'değiştiğinden araç hesaplayamıyor. Doçentlik dosyanızda kullandığınız yayın ve '
    .'faaliyetler profesörlük başvurusunda TEKRAR KULLANILAMIYOR; ayrıca doçent unvanından '
    .'sonra birinci yazar olduğunuz, araştırmaya dayalı bir eseri başlıca araştırma eseri '
    .'olarak göstermeniz gerekiyor.';

$DOC_NOTU = 'Doçent kadrosuna atanmak için puan barajı yok. MADDE 12 iki koşul arıyor: '
    .'başvurulan bilim alanında doçent unvanına sahip olmak ve doktora, tıpta uzmanlık ya da '
    .'sanatta yeterlik unvanını aldığınız tarihten sonra en az iki farklı akademik yarıyılda '
    .'fiilen ders vermiş olmak.';

$esikler = [];

foreach ([
    ['ad' => 'Fen, Mimarlık, Mühendislik, Sağlık ve Ziraat', 'anahtar' => 'fen', 'alan' => $FEN,
        'cekirdek' => 'ESER-A-CEKIRDEK', 'eser' => 'ESER-A', 'yeniden' => 'YENIDEN-A',
        'cekirdekAd' => '1 (a, b) bölümünden (SSCI, SCI, SCI-Expanded ya da AHCI dergileri)',
        'eserAd' => '1 (a, b, c, d) ya da 4 (a, b, c, d) bölümlerinden (uluslararası makale ve kitap)',
        'yenidenAd' => '1 (a, b, c, d) ve 2 (a, b) bölümlerinden'],
    ['ad' => 'Eğitim, Filoloji, Hukuk ve Sosyal Bilimler', 'anahtar' => 'sosyal', 'alan' => $SOSYAL,
        'cekirdek' => 'ESER-B-CEKIRDEK', 'eser' => 'ESER-B', 'yeniden' => 'YENIDEN-B',
        'cekirdekAd' => '1 (a, b, c, d) ya da 2 (a, b) bölümünden (uluslararası ya da ulusal hakemli makale)',
        'eserAd' => '1, 2 ya da 4. bölümlerden (uluslararası ve ulusal makale ile kitap)',
        'yenidenAd' => '1 (a, b, c, d), 2 (a, b) ya da 4 (a, b, c, d) bölümlerinden'],
] as $g) {
    $ortak = ['universite' => 'İzmir Bakırçay Üniversitesi', 'alan' => $g['alan'],
        'cetvel' => 'izmir-bakircay-2026'];

    $esikler[] = array_merge($ortak, [
        'anahtar' => 'izmir-bakircay-'.$g['anahtar'].'-dr',
        'kadro' => 'dr_ogr_uyesi',
        'notlar' => 'MADDE 13: en az 1\'i '.$g['cekirdekAd'].' olmak üzere '.$g['eserAd']
            .' en az 3 eser ve Puan Tablosundan toplam en az 40 puan.',
        'aday_notu' => $g['ad'].' temel alanlarında doktor öğretim üyeliği için iki koşul var: '
            .'en az üç eser ve toplam 40 puan. Üç eserden en az biri '.$g['cekirdekAd']
            .' olmalı, üçü birden '.$g['eserAd'].' gelmeli. Tablonun 3. bölümü (lisansüstü '
            .'tezlerden üretilmiş yayınlar) araca girilemediği için o bölümü işaret eden kollar '
            .'değerlendirilemiyor. Atamalar üç yıllık yapılıyor. '
            .'Puan tablosunda idari görev, sanatsal etkinlik ve toplumsal katkı satırı yok; bu '
            .'kayıtlarınız 40 puanlık barajı beslemiyor.',
        'sart' => Kalip::ve('Doktor öğretim üyeliğine ilk atanma koşulları', [
            Kalip::adet('Puan Tablosunun '.$g['cekirdekAd'].' en az 1 eser', [$g['cekirdek']], 1, madde: 'MADDE 13/1'),
            Kalip::adet('Puan Tablosunun '.$g['eserAd'].' en az 3 eser', [$g['eser']], 3, madde: 'MADDE 13/1'),
            Kalip::toplam(40),
        ]),
    ]);

    $esikler[] = array_merge($ortak, [
        'anahtar' => 'izmir-bakircay-'.$g['anahtar'].'-dr-yeniden',
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'notlar' => 'MADDE 14/3: son atanma tarihinden sonra '.$g['yenidenAd'].' en az 2 eser ve '
            .'en az 1 projede görev; proje yoksa eser sayısı 3\'e çıkar. Puan Tablosundan '
            .'toplam en az 40 puan.',
        'aday_notu' => 'Yeniden atamada yalnızca SON ATANMA TARİHİNDEN SONRAKİ yayın ve '
            .'faaliyetler sayılıyor; önceki atamada kullandığınız eserler yeniden ibraz '
            .'edilemiyor. Koşul iki yoldan sağlanabilir: '.$g['yenidenAd'].' iki eser ve en az '
            .'bir projede yürütücü, araştırmacı ya da danışman olarak görev almak; ya da proje '
            .'yoksa aynı bölümlerden üç eser. Her iki durumda da Puan Tablosundan 40 puan '
            .'gerekiyor. Yönerge, koşulları sağlayamayan adaya koşulların ve puanın yarısıyla '
            .'bir defaya mahsus yeniden atanma yolu açıyor; araç bu istisnayı uygulamıyor.',
        'sart' => Kalip::ve('Yeniden atanma koşulları', [
            Kalip::veya('Eser ve proje koşulu', [
                Kalip::ve('İki eser ve bir proje', [
                    Kalip::adet('Puan Tablosunun '.$g['yenidenAd'].' en az 2 eser', [$g['yeniden']], 2, donem: Kalip::SON_ATAMA_SONRASI, madde: 'MADDE 14/3'),
                    Kalip::adet('7. madde kapsamında en az 1 projede yürütücü, koordinatör, araştırmacı ya da danışman olarak görev almak', ['PROJE'], 1, donem: Kalip::SON_ATAMA_SONRASI, madde: 'MADDE 14/3-c'),
                ]),
                Kalip::adet('Proje koşulu sağlanmıyorsa Puan Tablosunun '.$g['yenidenAd'].' en az 3 eser', [$g['yeniden']], 3, donem: Kalip::SON_ATAMA_SONRASI, madde: 'MADDE 14/3-c'),
            ]),
            Kalip::toplam(40, donem: Kalip::SON_ATAMA_SONRASI),
        ]),
    ]);
}

$esikler[] = [
    'anahtar' => 'izmir-bakircay-docentlik',
    'universite' => 'İzmir Bakırçay Üniversitesi',
    'kadro' => 'docentlik',
    'alan' => $TUM,
    'cetvel' => 'izmir-bakircay-2026',
    'notlar' => 'MADDE 12: doçent unvanı ve doktora, tıpta uzmanlık ya da sanatta yeterlik '
        .'unvanından sonra en az iki farklı akademik yarıyılda fiilen ders vermiş olmak. Puan '
        .'barajı yok.',
    'aday_notu' => $DOC_NOTU,
    'sart' => Kalip::ve('Doçentlik koşulları', [
        Kalip::beyan('Başvurulan doçentlik kadrosunun bilim alanında ya da ÜAK\'ın belirlediği ilgili bilim alanlarında doçent unvanını almış olmak', 'MADDE 12/1-a'),
        Kalip::metrik('Doktora, tıpta uzmanlık ya da sanatta yeterlik unvanını aldıktan sonra önlisans, lisans veya lisansüstü düzeyde en az iki farklı akademik yarıyılda fiilen ders vermiş olmak', 'ders_yariyil', 2, Kalip::DOKTORA_SONRASI),
    ]),
];

$esikler[] = [
    'anahtar' => 'izmir-bakircay-profesorluk',
    'universite' => 'İzmir Bakırçay Üniversitesi',
    'kadro' => 'profesorluk',
    'alan' => $TUM,
    'cetvel' => 'izmir-bakircay-2026',
    'notlar' => 'MADDE 11: doçentlik unvanından sonraki yeni akademik çalışmalarla ÜAK doçentlik '
        .'başvuru şartlarını müstakilen yeniden sağlamak; birinci yazar olunan araştırmaya '
        .'dayalı bir eseri başlıca araştırma eseri olarak göstermek. Puan barajı yok.',
    'aday_notu' => $PROF_NOTU,
    'sart' => Kalip::ve('Profesörlük koşulları', [
        Kalip::hesaplanamiyor('Doçentlik unvanını aldıktan sonraki yeni akademik çalışmalarla, doçentlik unvanına esas başvuru tarihindeki (ya da güncel) ÜAK doçentlik başvuru şartlarını müstakilen yeniden sağlamış olmak', 'MADDE 11/1-2'),
        Kalip::beyan('Doçent unvanını aldıktan sonra birinci yazar olduğunuz ve araştırmaya dayalı eserlerden birini başlıca araştırma eseri olarak göstermek', 'MADDE 11/4-a'),
        Kalip::beyan('Doçentlik dosyasında kullanılan yayın ve faaliyetleri profesörlük başvurusunda kullanmamak', 'MADDE 11/3'),
    ]),
];

return $esikler;
