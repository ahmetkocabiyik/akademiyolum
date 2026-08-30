<?php

/**
 * AFYONKARAHİSAR SAĞLIK BİLİMLERİ ÜNİVERSİTESİ — Öğretim Üyeliğine
 * Yükseltilme ve Atanma Yönergesi
 * Kaynak: pdf/17536927672.afyonkarahisarsaglikbilimleriuniversitesi.pdf
 * (14 sayfa, Senato 2018/…)
 *
 * ── YAPI: TEK CETVEL, İKİ ALAN GRUBU ──
 * Yönerge alan ayrımını yalnızca DOÇENTLİK ve PROFESÖRLÜK barajlarında
 * yapıyor; Dr. Öğr. Üyesi kademesinde tüm alanlar aynı sayıları paylaşıyor.
 *
 *   Grup 1 — Fen Bilimleri ve Sağlık Bilimleri → alan: fen, sağlık
 *   Grup 2 — Sosyal ve Beşeri Bilimler         → alan: sosyal
 *
 * Yönerge yalnızca bu üç temel alanı (Fen, Sağlık, Sosyal) açıkça anıyor;
 * üniversitenin "Sağlık Bilimleri Üniversitesi" olması ve Dr./Doçent
 * kademelerinde başka hiçbir alandan söz edilmemesi, kapsamın gerçekten bu
 * üçüyle sınırlı olduğunu gösteriyor. Profesörlük barajının h bendi
 * ("Eğitim Bilimleri, Fen Bilimleri, Matematik, Sağlık Bilimleri,
 * Mühendislik, Spor Bilimleri, Sosyal Beşeri ve İdari Bilimler ve Hukuk
 * temel alanlarında…") YÖK'ün standart temel alan listesini olduğu gibi
 * kopyalamış görünüyor; Dr./Doçent kademesinde bu alanlardan hiçbiri
 * anılmadığı için profesörlük eşiği de yalnızca Fen/Sağlık/Sosyal'e
 * yazıldı — diğer alanlar (mühendislik, eğitim, hukuk, spor…) kapsam dışı
 * bırakıldı.
 *
 * ── YENİDEN ATANMA: KAYAN PENCERE ──
 * Madde V/1-ç: "yeniden atanma öncesindeki iki yıl için en az 150 puan."
 * `Kalip::sonYil(2)` ile karşılandı.
 *
 * ── "TOPLAM PUANIN A-E'DEN EN AZ N PUANI" GENİŞ ŞEKİLDE YENİDEN ATANMAYA DA
 * UYGULANDI ──
 * Madde V/1 dört bent (a,b,c,ç,d) sırayla ilerliyor; d bendi ("Atanma için
 * istenen toplam puanın … 80 puanını Ek-1 A-E maddelerinden almış olmak")
 * c (ilk atama) ile ç (yeniden atanma) bentlerinin İKİSİNE de mi yoksa
 * yalnızca birine mi uygulandığı metinden kesin çıkarılamıyor. Daha GENİŞ
 * (her ikisine de uygulanan) okuma seçildi — bu, adayı OLDUĞUNDAN HAZIR
 * göstermemek için güvenli yön: eksik koşul yazmak yerine fazladan bir alt
 * şart eklemek adayı zorlaştırıyor, kolaylaştırmıyor.
 *
 * ── PROFESÖRLÜK: ALAN BAZLI MAKALE ŞARTLARI (e/f/g) ──
 * Madde VII/1-e ve f birlikte okundu: e) A.1 ve/veya A.2'den doçentlik
 * sonrası başlıca yazarlı en az 1 makale; f) "ilave olarak" TR Dizin'de VEYA
 * yine A.1/A.2'den doçentlik sonrası başlıca yazarlı BİR makale DAHA. İkisi
 * birlikte "en az 2 başlıca yazarlı makale, en az biri A.1/A.2'den" olarak
 * yazıldı (Fen ve Sağlık Bilimleri). Sosyal Bilimler için g bendi ayrı:
 * A.1, A.2 veya A.3'ten doçentlik sonrası başlıca yazarlı en az 2 makale.
 * h bendinin bağımsız 400 puanlık A.1-A.3 barajı her iki grupta da aynı.
 *
 * "Tezden üretilmemiş" niteliği ayrıca yazılmadı: `makale` kategorisindeki
 * bir faaliyet zaten `tez_yayini` kategorisinden farklı bir kayıt, aday
 * aynı çalışmayı iki kategoride birden tutamıyor — nitelik örtük olarak
 * sağlanıyor.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   Madde V/1-f, VI/1-d, VII/1-ı: öğretim üyesi sayısı yetersiz birimlerde
 *       koşulların %50'sinin aranması — birimin öğretim üyesi sayısı
 *       profilde yok, uygulanamadı (koşul o birimlerde OLDUĞUNDAN ZOR
 *       görünür, güvenli yönde bir sapma).
 *   Madde V/1-e: toplam puan herhangi bir atama döneminde 600'ü geçerse ya
 *       da doçentlik başvurusu asgari koşulları sağlanmışsa dosya
 *       istenmemesi — süreç kolaylığı, asıl puan koşulunu değiştirmiyor,
 *       eşiğe yazılmadı.
 *   Madde VI/1-a, VII/1-a/i: ÜAK doçentlik unvanı ve yurt dışı unvan
 *       denkliği — beyan.
 *   Madde VII/1-c: doçent unvanından sonra en az 5 yıl çalışmış olmak —
 *       kıdem süresi olarak beyan edildi (motorun dönem mekanizması bir
 *       SÜRE eşiği değil TARİH SONRASI filtresi kurduğu için doğrudan
 *       "5 yıl" şartına çevrilemiyor).
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/afyon-saglik-2018.php
 */

use App\Services\Scoring\Sart\Kalip;

$CETVEL = 'afyon-saglik-2018';
$UNIVERSITE = 'Afyonkarahisar Sağlık Bilimleri Üniversitesi';
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;
$SON2YIL = Kalip::sonYil(2);

$esikler = [];

// ══════════════════════════════════════════════════════════════════════════
// DR. ÖĞRETİM ÜYESİ (tüm alanlar aynı sayıları paylaşıyor)
// ══════════════════════════════════════════════════════════════════════════

$esikler[] = [
    'anahtar' => 'afyon-saglik-dr',
    'aday_notu' => 'Tüm faaliyetlerinizden toplam en az 150 puan gerekiyor; bu 150 puanın en '
        .'az 80\'i makale, bildiri, kitap, patent ve çeviri (A-E) kalemlerinden gelmeli.',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi',
    'alan' => ['fen', 'saglik', 'sosyal'],
    'cetvel' => $CETVEL,
    'notlar' => 'Madde V/1-c: ilk atamada en az 150 puan. Madde V/1-d: bu puanın en az 80\'i '
        .'A-E maddelerinden.',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna atanma', [
        Kalip::beyan('İlgili alanda doktora veya tıpta/diş hekimliğinde/eczacılıkta uzmanlık eğitimini tamamlamış olmak', 'Madde V/1-b'),
        Kalip::puanDan('Makale, bildiri, kitap, patent ve çeviri (A-E) kalemlerinizden en az 80 puan', ['A-E'], 80, madde: 'Madde V/1-d'),
        Kalip::toplam(150),
    ]),
];

$esikler[] = [
    'anahtar' => 'afyon-saglik-dr-yeniden',
    'aday_notu' => 'Yeniden atanma öncesindeki SON İKİ YIL içindeki faaliyetlerinizden toplam '
        .'en az 150 puan gerekiyor; bu 150 puanın en az 80\'i son iki yıldaki makale, bildiri, '
        .'kitap, patent ve çeviri (A-E) kalemlerinden gelmeli.',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi_yeniden',
    'alan' => ['fen', 'saglik', 'sosyal'],
    'cetvel' => $CETVEL,
    'notlar' => 'Madde V/1-ç: yeniden atanma öncesindeki iki yıl için en az 150 puan. Madde '
        .'V/1-d\'nin A-E alt şartı burada da uygulandı (gerekçe dosya başlığında).',
    'sart' => Kalip::ve('Doktor Öğretim Üyeliğine yeniden atanma', [
        Kalip::puanDan(
            'Son iki yılda makale, bildiri, kitap, patent ve çeviri (A-E) kalemlerinizden en az 80 puan',
            ['A-E'], 80, $SON2YIL, madde: 'Madde V/1-d',
        ),
        Kalip::toplam(150, $SON2YIL),
    ]),
];

// ══════════════════════════════════════════════════════════════════════════
// DOÇENTLİK
// ══════════════════════════════════════════════════════════════════════════

$esikler[] = [
    'anahtar' => 'afyon-saglik-docent-fen-saglik',
    'aday_notu' => 'Tüm faaliyetlerinizden toplam en az 800 puan gerekiyor; bu 800 puanın en '
        .'az 400\'ü makale, bildiri, kitap, patent ve çeviri (A-E) kalemlerinden gelmeli.',
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => ['fen', 'saglik'],
    'cetvel' => $CETVEL,
    'notlar' => 'Madde VI/1-c: en az 800 puan. Madde VI/1-ç: Fen ve Sağlık Bilimleri '
        .'alanlarında bu puanın en az 400\'ü A-E maddelerinden.',
    'sart' => Kalip::ve('Doçent kadrosuna atanma', [
        Kalip::beyan('ÜAK doçentlik unvanına sahip olmak', 'Madde VI/1-a'),
        Kalip::puanDan('Makale, bildiri, kitap, patent ve çeviri (A-E) kalemlerinizden en az 400 puan', ['A-E'], 400, madde: 'Madde VI/1-ç'),
        Kalip::toplam(800),
    ]),
];

$esikler[] = [
    'anahtar' => 'afyon-saglik-docent-sosyal',
    'aday_notu' => 'Tüm faaliyetlerinizden toplam en az 800 puan gerekiyor; bu 800 puanın en '
        .'az 300\'ü makale, bildiri, kitap, patent ve çeviri (A-E) kalemlerinden gelmeli.',
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => ['sosyal'],
    'cetvel' => $CETVEL,
    'notlar' => 'Madde VI/1-c: en az 800 puan. Madde VI/1-ç: Sosyal ve Beşeri Bilimler '
        .'alanında bu puanın en az 300\'ü A-E maddelerinden.',
    'sart' => Kalip::ve('Doçent kadrosuna atanma', [
        Kalip::beyan('ÜAK doçentlik unvanına sahip olmak', 'Madde VI/1-a'),
        Kalip::puanDan('Makale, bildiri, kitap, patent ve çeviri (A-E) kalemlerinizden en az 300 puan', ['A-E'], 300, madde: 'Madde VI/1-ç'),
        Kalip::toplam(800),
    ]),
];

// ══════════════════════════════════════════════════════════════════════════
// PROFESÖRLÜK
// ══════════════════════════════════════════════════════════════════════════

$esikler[] = [
    'anahtar' => 'afyon-saglik-profesor-fen-saglik',
    'aday_notu' => 'Doçentlik unvanınızdan SONRAKİ çalışmalarınıza bakılıyor: SCI, '
        .'SCI-Expanded, SSCI ya da AHCI dergisinde en az 1 başlıca yazarlı makaleniz; bu '
        .'dergilerde ya da TR Dizin\'de en az 1 başlıca yazarlı makale DAHA (toplamda en az 2 '
        .'başlıca yazarlı makale, en az biri dizinli dergiden); dizinli dergilerdeki '
        .'makalelerinizden en az 400 puan ve '
        .'doçentlik sonrası toplamdan en az 800 puan gerekiyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'profesorluk',
    'alan' => ['fen', 'saglik'],
    'cetvel' => $CETVEL,
    'notlar' => 'Madde VII/1-e+f: doçentlik sonrası A.1/A.2\'den en az 1 başlıca yazarlı '
        .'makale, ilaveten TR Dizin veya A.1/A.2\'den bir makale daha (toplam en az 2). Madde '
        .'VII/1-h: A.1-A.3\'ten doçentlik sonrası en az 400 puan. Madde VII/1-d: doçentlik '
        .'sonrası toplam en az 800 puan.',
    'sart' => Kalip::ve('Profesör kadrosuna atanma', [
        Kalip::beyan('Doçent unvanını aldıktan sonra en az 5 yıl süreyle ilgili bilim alanında çalışmış olmak', 'Madde VII/1-c'),
        Kalip::adet(
            'Doçentlik unvanınızdan sonra SCI, SCI-Expanded, SSCI ve AHCI dergilerinde en az 1 başlıca yazarlı makaleniz olmalı',
            ['A1-A2'], 1, yazar: 'baslica', donem: $DOCENTLIK, madde: 'Madde VII/1-e',
        ),
        Kalip::adet(
            'Doçentlik unvanınızdan sonra SCI, SCI-Expanded, SSCI, AHCI ya da TR Dizin dergilerinde toplam en az 2 başlıca yazarlı makaleniz olmalı',
            ['A1-A2-TRDIZIN'], 2, yazar: 'baslica', donem: $DOCENTLIK, madde: 'Madde VII/1-f',
        ),
        Kalip::puanDan(
            'Doçentlik unvanınızdan sonra SCI, SCI-Expanded, SSCI, AHCI, ESCI ve TR Dizin dergilerindeki makalelerinizden en az 400 puan',
            ['A1-A2-A3'], 400, $DOCENTLIK, madde: 'Madde VII/1-h',
        ),
        Kalip::toplam(800, $DOCENTLIK),
    ]),
];

$esikler[] = [
    'anahtar' => 'afyon-saglik-profesor-sosyal',
    'aday_notu' => 'Doçentlik unvanınızdan SONRAKİ çalışmalarınıza bakılıyor: SCI, '
        .'SCI-Expanded, SSCI, AHCI, ESCI ya da TR Dizin dergilerinde toplam en az 2 başlıca '
        .'yazarlı makaleniz olmalı; aynı kalemlerden '
        .'en az 400 puan ve doçentlik sonrası toplamdan en az 800 puan gerekiyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'profesorluk',
    'alan' => ['sosyal'],
    'cetvel' => $CETVEL,
    'notlar' => 'Madde VII/1-g: doçentlik sonrası A.1, A.2 veya A.3\'ten en az 2 başlıca '
        .'yazarlı makale. Madde VII/1-h: A.1-A.3\'ten doçentlik sonrası en az 400 puan. Madde '
        .'VII/1-d: doçentlik sonrası toplam en az 800 puan.',
    'sart' => Kalip::ve('Profesör kadrosuna atanma', [
        Kalip::beyan('Doçent unvanını aldıktan sonra en az 5 yıl süreyle ilgili bilim alanında çalışmış olmak', 'Madde VII/1-c'),
        Kalip::adet(
            'Doçentlik unvanınızdan sonra SCI, SCI-Expanded, SSCI, AHCI, ESCI ve TR Dizin dergilerinde toplam en az 2 başlıca yazarlı makaleniz olmalı',
            ['A1-A2-A3'], 2, yazar: 'baslica', donem: $DOCENTLIK, madde: 'Madde VII/1-g',
        ),
        Kalip::puanDan(
            'Doçentlik unvanınızdan sonra SCI, SCI-Expanded, SSCI, AHCI, ESCI ve TR Dizin dergilerindeki makalelerinizden en az 400 puan',
            ['A1-A2-A3'], 400, $DOCENTLIK, madde: 'Madde VII/1-h',
        ),
        Kalip::toplam(800, $DOCENTLIK),
    ]),
];

return $esikler;
