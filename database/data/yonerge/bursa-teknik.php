<?php

/**
 * BURSA TEKNİK ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma
 * Yönergesi
 * Kaynak: pdf/17536991712.bursateknikuniverstesi.pdf (89 sayfa, Senato
 * 27/05/2024-2024-9/1, YÖK onayı 24/10/2024; uygulama 15 Haziran 2025,
 * Yapay Zekâ ve Makine Öğrenmesi ile Veri Bilimi ve Analitiği bölümlerinde
 * 15 Haziran 2024)
 *
 * ── YAPI: BÖLÜM BÖLÜM AKTİVİTE TABLOLARI ──
 * Korpustaki en ayrıntılı Tablo 1. Yönerge altı fakültenin OTUZ BİR bölümü
 * için ayrı sütun veriyor ve her kadroyu dört-beş "Aktivite" katmanına
 * bölüyor:
 *
 *   Aktivite 1  YAYINLAR — bölüm başına adet ("1A: 3a", "1C: 2a+3a").
 *               Kodlardan EN AZ BİRİ sağlanmalı (`Kalip::veya`).
 *   Aktivite 2  PROJELER — bölüm başına asgari puan (Dr. yeniden atanmada
 *               puan değil ADET).
 *   Aktivite 3  PROJE ALTERNATİFİ — Aktivite 2 sağlanamazsa bunun
 *               kodlarından biri. Yani (Aktivite 2 VEYA Aktivite 3).
 *   Aktivite 4  Dr. ilk atanmada Tablo 2'den toplam puan; diğer kadrolarda
 *               on altı alt ölçütten en az 2/3/4'ü (`Kalip::kIle`).
 *   Aktivite 5  Dr. yeniden atanma, doçent ve profesörde Tablo 2'den toplam
 *               puan.
 *
 * ── "TECRÜBE MEVCUT" VARYANTI GİRİLMEDİ ──
 * Her kadronun İKİ tablosu var: "Yurtdışı veya Yurtiçi Kurum Araştırma
 * Tecrübesi Mevcut Değil" ve "Mevcut". Tecrübeli varyant belirgin biçimde
 * hafif (Bilgisayar Mühendisliği doçentlikte Q1-Q2 yayın 3 yerine 2; Dr. ilk
 * atanmada tecrübeli adaydan Aktivite 2/3 hiç istenmiyor).
 *
 * Bu tecrübe MADDE 6/e-f-g'de tanımlı: yurt dışında kesintisiz en az 9 aylık
 * araştırma ya da TÜBİTAK/YÖK burs programı kapsamında yurt içinde kurum dışı
 * 9 aylık çalışma, üstelik o çalışmadan danışmanın da adı geçen bir WoS Q1-Q3
 * yayın kabulü. Ne süre ne görevlendirme profilde tutuluyor; KONVANSIYONLAR'ın
 * "kurum/süre bilgisi gerektiren koşullar girilmez" kuralı gereği yalnızca
 * TECRÜBESİZ (zor) varyant girildi. Tecrübesi olan aday burada olduğundan ZOR
 * bir eşik görür; her eşiğin aday notu bunu söylüyor.
 *
 * ── BÖLÜM → temel alan EŞLEMESİ VE `birim` ──
 * Otuz bir bölüm yedi temel alana düşüyor ve çoğu aynı alanda buluşuyor;
 * motor `bul()` içinde birden fazla aday görünce `birim` ile ayırıyor, bu
 * yüzden HER eşik bölüm adını `birim` olarak taşıyor (Sabancı'daki program
 * bazlı ayrımın aynısı).
 *
 * Yapay Zekâ ve Makine Öğrenmesi ile Veri Bilimi ve Analitiği bölümleri
 * yönergede Doğa Bilimleri başlığı altında ama ÜAK temel alanı mühendislik;
 * `muhendislik`e bağlandılar. Peyzaj Mimarlığı, Orman Fakültesi'nde olmasına
 * rağmen ÜAK'ta Mimarlık-Planlama-Tasarım temel alanında; `mimarlik`e
 * bağlandı. Orman Endüstri ve Orman Mühendisliği `ziraat` (Ziraat, Orman ve
 * Su Ürünleri) temel alanına düştü.
 *
 * Yönergenin anmadığı temel alanlar (saglik, egitim, hukuk, ilahiyat, spor,
 * guzel_sanatlar) kapsam dışı: üniversitenin o alanlarda bölümü yok.
 *
 * ── "a" DİPNOTU: SAYININ YARISINDA BAŞLICA YAZARLIK ──
 * Aktivite 1 ve 3'ün bütün hücrelerinde "a" üst simgesi var: "Toplam sayının
 * yarısında başlıca yazar olunmalıdır (1 üzerindeki küsüratlı sayılar bir alt
 * tam sayıya yuvarlanır)". Her adet düğümünün yanına `floor(N/2)` büyüklüğünde
 * ikinci bir `baslica` düğümü eklendi; yarısı 0 çıkan hücrelerde (N = 1)
 * düğüm hiç yazılmadı.
 *
 * ── MADDE 6/n-o: İSTENENİN %50'Sİ DÖNEM İÇİNDE ──
 * Doçentlikte istenen sayı ya da puanın en az %50'si DOKTORA sonrası,
 * profesörlükte ÜAK doçentlik unvanı sonrası olmalı. Her adet ve toplam
 * düğümünün yanına `floor(N/2)` büyüklüğünde dönemli bir ikiz düğüm eklendi.
 * Dr. ilk atanmada yönerge dönem koşulu yazmıyor, dolayısıyla yazılmadı;
 * yeniden atanmada MADDE 6/l uyarınca ölçütler atanma dönemi içinde
 * sağlanmalı (`SON_ATAMA_SONRASI`) ve Aktivite 5'in 150 puanının en az 50'si
 * yeniden atanma dönemi içinde olmalı.
 *
 * ── AKTİVİTE 4'ÜN ON ALTI ALT ÖLÇÜTÜNDEN BEŞİ GİRİLEMEDİ ──
 * Değerlendirilebilen on bir ölçüt: 4A (tez), 4B (kongre görevi/davetli
 * konuşmacılık), 4C (tam metin bildiri), 4D (uluslararası kitap), 4E (ulusal
 * kitap), 4F (altı dönem ders), 4H (yarışma danışmanlığı/jüri/hakemlik),
 * 4J (TR Dizin veya diğer uluslararası makale), 4L (ödül), 4M (burs),
 * 4N (patent/faydalı model).
 *
 * Girilemeyenler ve nedeni:
 *   4G — "en az 6 ay süre ile idari görev": görev süresi kayıtta yok.
 *   4I — "açık kaynak kodlu yazılım geliştirmek/ticarileştirmek": sözlükte
 *        karşılıksız, üstelik alt şartlardan ikisinin sağlanması isteniyor.
 *   4K — WoS h-indeksi (yeniden atanmada ≥5, doçentlikte ≥7): profil özelliği.
 *   4O — "proje başvurusunda bulunmak": başvuru satırları cetvele girmedi.
 *   4P — "ortak dersler bölümünde iki dönem ders vermiş olmak": dersin hangi
 *        bölümde verildiği kayıtta yok.
 * Beş ölçütün düşmesi sayımı ZORLAŞTIRIYOR (aday on bir ölçüt içinden 2/3/4
 * bulmak zorunda); yön §0'a uygun ama aday notunda uyarıldı.
 *
 * ── KAYNAKTAKİ ETİKETLEME TUZAĞI ──
 * İçindekiler her fakülte için a-g harflerini sayıyor ama İnsan ve Toplum
 * Bilimleri bölümünde tabloların "(devamı)" sayfaları da harf almış: 1.2.e
 * doçentliğin devamı, 1.2.g tecrübeli doçentliğin devamı, profesörlük ise
 * 1.2.h. Harf sırasına güvenip 1.2.f'yi profesörlük sanmak, doçentliğin
 * tecrübeli varyantını profesörlük eşiği olarak girmek olurdu.
 *
 * ── AKTİVİTE 2 EŞİĞİ BAŞLIKTA DEĞİL, TABLONUN İÇİNDE ──
 * "Aktivite-2 (… en az 20 Puan)" başlığı bölümlerin EN YÜKSEĞİNİ yazıyor;
 * gerçek bölüm eşiği proje tablosunun içinde, 2C satırının hizasındaki
 * hücrelerde duruyor (Denizcilik'te 15/20, Orman'da 20/20/15). Başlığa
 * güvenmek Denizcilik İşletmeleri Yönetimi adayına 15 yerine 20 puanlık bir
 * baraj gösterirdi.
 *
 * ── GİRİLMEYEN DİĞER KOŞULLAR ──
 *   MADDE 6/a-b-c: yabancı dil şartı doğrudan sayı vermiyor, Doçentlik
 *       Yönetmeliği'ne ve yabancı dille öğretim mevzuatına devrediyor; o
 *       mevzuatın öngördüğü 55 puanlık taban `Kalip::yds(55)` ile yalnızca
 *       Dr. Öğr. Üyesi ilk atanmaya yazıldı, doçent ve profesörde ÜAK
 *       doçentlik unvanı zaten dil şartını kapsıyor.
 *   MADDE 6/k: aynı çalışmanın Aktivite kategorilerinde bir kez sayılması —
 *       motor zaten bir faaliyeti tek maddeye eşliyor.
 *   MADDE 6/z ve MADDE 12: yeni bölüm açılması ve yabancı uyruklu öğretim
 *       üyeleri — idari.
 *   MADDE 6/m: doçent unvanı almış Dr. Öğr. Üyesinin yeniden atanmada yalnız
 *       doçentlik belgesi sunması — beyan olarak eklendi.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/bursa-teknik-2024.php
 */

use App\Services\Scoring\Sart\Kalip;

$CETVEL = 'bursa-teknik-2024';
$UNIVERSITE = 'Bursa Teknik Üniversitesi';
$DOKTORA = Kalip::DOKTORA_SONRASI;
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;
$SON_ATAMA = Kalip::SON_ATAMA_SONRASI;

/**
 * Aktivite 1 ve 3 kod satırlarının küme adları. Çift değerli hücreler
 * ("2a+3a") iki kümeyi birden istiyor.
 */
$KUME = [
    'Q1-Q2' => ['Q1-Q2', 'WoS Q1-Q2 dergilerinde'],
    'Q1-Q3' => ['Q1-Q3', 'WoS Q1-Q2-Q3 dergilerinde'],
    'AHCI-Q1-Q3' => ['AHCI-Q1-Q3', 'AHCI ya da WoS Q1-Q2-Q3 dergilerinde'],
    'ESCI-Q1-Q4' => ['ESCI-Q1-Q4', 'AHCI, Scopus, ESCI ya da WoS Q1-Q4 dergilerinde'],
    'GENIS-YAYIN' => ['GENIS-YAYIN', 'uluslararası endeksli veya TR Dizin dergilerde ya da kitap/kitap bölümü olarak'],
    'EK-KUME' => ['EK-KUME', 'WoS Q4, ESCI, Scopus, TR Dizin dergilerinde, kitap/kitap bölümü olarak ya da uluslararası konferans tam metin bildirisi olarak'],
    'EK-KUME-TASARIM' => ['EK-KUME-TASARIM', 'WoS Q4, ESCI, Scopus, TR Dizin dergilerinde, tanınmış yayınevi kitabı/bölümü, mesleki yarışma derecesi ya da uluslararası konferans tam metin bildirisi olarak'],
];

/**
 * Bir Aktivite 1/3 hücresini düğüme çevirir.
 *
 * `$hucre` ya tek küme için sayı (`['Q1-Q2', 3]`) ya iki küme için sayı
 * çifti (`[['AHCI-Q1-Q3', 2], ['EK-KUME', 3]]`) ya da null (o bölümde bu
 * kod yok, kaynakta "-").
 *
 * @param  list<array{0: string, 1: int}>  $parcalar
 * @param  array<string, mixed>|null  $donem  MADDE 6/n-o'nun %50 dönemi
 * @return array<string, mixed>
 */
$kodDugumu = function (array $parcalar, ?array $donem, string $madde) use ($KUME): array {
    $cocuklar = [];

    foreach ($parcalar as [$kumeAdi, $sayi]) {
        [$grup, $metin] = $KUME[$kumeAdi];
        $cocuklar[] = Kalip::adet("{$metin} en az {$sayi} yayınınız olmalı", [$grup], $sayi, madde: $madde);

        $yari = intdiv($sayi, 2);

        if ($yari >= 1) {
            $cocuklar[] = Kalip::adet(
                "Bu yayınların en az {$yari} tanesinde başlıca yazar olmalısınız",
                [$grup], $yari, yazar: 'baslica', madde: $madde,
            );
        }

        if ($donem !== null && $yari >= 1) {
            $cocuklar[] = Kalip::adet(
                "Bu yayınların en az {$yari} tanesi ilgili dönemde olmalı",
                [$grup], $yari, donem: $donem, madde: $madde,
            );
        }
    }

    if (count($cocuklar) === 1) {
        return $cocuklar[0];
    }

    // Başlık kaynağın ölçüt KODUNU taşımaz (§2: aday metninde kod yasak);
    // kod izlenebilirlik için çocukların `madde` alanında duruyor. Adayın
    // görmesi gereken, bu bloğun hangi yayın kümesini istediği — aynı `veya`
    // altında birkaç blok yan yana durduğunda ayırt edici olan da bu.
    if (count($parcalar) > 1) {
        $baslik = 'İki ayrı yayın kümesinin ikisi de gerekli';
    } else {
        $metin = $KUME[$parcalar[0][0]][1];
        $baslik = mb_strtoupper(mb_substr($metin, 0, 1), 'UTF-8').mb_substr($metin, 1).' istenen yayınlar';
    }

    return Kalip::ve($baslik, $cocuklar);
};

/**
 * Aktivite 4'ün değerlendirilebilen on bir alt ölçütü.
 *
 * @param  array<string, mixed>|null  $donem
 * @return list<array<string, mixed>>
 */
$aktivite4 = function (?array $donem): array {
    $m = fn (string $k): string => "Tablo 1 Aktivite 4/{$k}";

    return [
        Kalip::adet('Danışmanı olduğunuz en az 1 lisansüstü öğrenciyi mezun etmiş ya da danışmanlığını üstlenmiş olmalısınız', ['TEZ'], 1, donem: $donem, madde: $m('4A')),
        Kalip::adet('Uluslararası bir kongre, konferans veya sempozyumda düzenleme kurulunda görev almış ya da davetli konuşmacı olmalısınız', ['DAVETLI', 'J.5-J.8'], 1, donem: $donem, madde: $m('4B')),
        Kalip::adet('Hakemli bir konferansta sözlü sunulmuş ve tam metin yayımlanmış en az 1 bildiriniz olmalı', ['TAM-METIN-BILDIRI'], 1, donem: $donem, madde: $m('4C')),
        Kalip::adet('Uluslararası yayınevince yayımlanmış en az 1 kitap ya da kitap bölümünüz olmalı', ['ULUSLARARASI-KITAP'], 1, donem: $donem, madde: $m('4D')),
        Kalip::adet('Ulusal yayınevince yayımlanmış en az 1 kitap ya da kitap bölümünüz olmalı', ['ULUSAL-KITAP'], 1, donem: $donem, madde: $m('4E')),
        Kalip::adet('En az 6 dönem lisans veya lisansüstü ders vermiş olmalısınız', ['TUM-DERS'], 6, donem: $donem, madde: $m('4F')),
        Kalip::adet('Ulusal veya uluslararası bir yarışmada danışmanlık, jüri üyeliği ya da hakemlik yapmış olmalısınız', ['J.11-uluslararasi', 'J.11-ulusal', 'J.9-J.10'], 1, donem: $donem, madde: $m('4H')),
        Kalip::adet('ULAKBİM TR Dizin ya da diğer uluslararası hakemli dergilerde en az 1 makaleniz olmalı', ['A.7', 'A.8'], 1, donem: $donem, madde: $m('4J')),
        Kalip::adet('En az 1 ödül almış olmalısınız', ['ODUL'], 1, donem: $donem, madde: $m('4L')),
        Kalip::adet('En az 1 burs almış olmalısınız', ['BURS'], 1, donem: $donem, madde: $m('4M')),
        Kalip::adet('Ulusal veya uluslararası patent ya da faydalı model tesciliniz olmalı', ['PATENT'], 1, donem: $donem, madde: $m('4N')),
    ];
};

/**
 * Kadro çerçevesi: dönem, Aktivite 4 sayısı, unvan beyanı, dil şartı.
 *
 * @var array<string, array{donem: array<string, mixed>|null, k: int|null, yds: bool, ad: string}>
 */
$KADROLAR = [
    'dr_ogr_uyesi' => ['donem' => null, 'k' => null, 'yds' => true, 'ad' => 'Doktor Öğretim Üyesi kadrosuna ilk atanma'],
    'dr_ogr_uyesi_yeniden' => ['donem' => $SON_ATAMA, 'k' => 2, 'yds' => false, 'ad' => 'Doktor Öğretim Üyeliğine yeniden atanma'],
    'docentlik' => ['donem' => $DOKTORA, 'k' => 3, 'yds' => false, 'ad' => 'Doçent kadrosuna atanma'],
    'profesorluk' => ['donem' => $DOCENTLIK, 'k' => 4, 'yds' => false, 'ad' => 'Profesör kadrosuna yükseltilme'],
];

/**
 * Tablo 1'in altı fakültesi. `akt1`/`akt3` satırları kod → bölüm başına
 * hücre; hücre null ise kaynakta "-" var demektir.
 *
 * Hücre biçimi: [küme, sayı] ya da [[küme, sayı], [küme, sayı]].
 */
$Q12 = 'Q1-Q2';
$Q13 = 'Q1-Q3';
$AQ3 = 'AHCI-Q1-Q3';
$EK = 'EK-KUME';
$EKT = 'EK-KUME-TASARIM';
$E14 = 'ESCI-Q1-Q4';
$GEN = 'GENIS-YAYIN';

/** Tek küme hücresi. */
$t = fn (string $k, int $n): array => [[$k, $n]];
/** Çift küme hücresi. */
$c = fn (string $k1, int $n1, string $k2, int $n2): array => [[$k1, $n1], [$k2, $n2]];

$FAKULTELER = [
    [
        'ad' => 'Denizcilik Fakültesi',
        'bolumler' => [
            ['Denizcilik İşletmeleri Yönetimi', 'sosyal'],
            ['Gemi İnşaatı ve Gemi Makineleri Mühendisliği', 'muhendislik'],
        ],
        'kadrolar' => [
            'dr_ogr_uyesi' => [
                'akt1' => ['1A' => [$t($Q12, 1), $t($Q12, 2)], '1B' => [$t($AQ3, 2), $t($AQ3, 3)], '1C' => [$c($AQ3, 1, $EK, 3), $c($AQ3, 2, $EK, 2)]],
                'akt2' => ['puan', [15, 20]],
                'akt3' => ['3A' => [$t($Q12, 1), $t($Q12, 1)], '3B' => [$t($AQ3, 2), $t($AQ3, 2)], '3C' => [$c($AQ3, 1, $EK, 2), $c($AQ3, 1, $EK, 2)]],
                'toplam' => 100,
            ],
            'dr_ogr_uyesi_yeniden' => [
                'akt1' => ['1A' => [$t($AQ3, 1), $t($AQ3, 2)], '1B' => [$c($AQ3, 1, $EK, 1), $c($AQ3, 1, $EK, 2)]],
                'akt2' => ['adet', [1, 1]],
                'akt3' => ['3A' => [$t($Q12, 1), $t($Q12, 1)], '3C' => [$c($AQ3, 1, $EK, 2), $c($AQ3, 1, $EK, 2)]],
                'toplam' => 150,
            ],
            'docentlik' => [
                'akt1' => ['1A' => [$t($Q12, 2), $t($Q12, 4)], '1B' => [$t($AQ3, 3), $t($AQ3, 5)], '1C' => [$c($AQ3, 2, $EK, 3), $c($AQ3, 4, $EK, 2)]],
                'akt2' => ['puan', [20, 30]],
                'akt3' => ['3A' => [$t($Q12, 1), $t($Q12, 1)], '3B' => [$t($AQ3, 2), $t($AQ3, 2)], '3C' => [$c($AQ3, 1, $EK, 2), $c($AQ3, 1, $EK, 2)]],
                'toplam' => 250,
            ],
            'profesorluk' => [
                'akt1' => ['1A' => [$t($Q12, 3), $t($Q12, 7)], '1B' => [$t($AQ3, 4), $t($AQ3, 8)], '1C' => [$c($AQ3, 3, $EK, 5), $c($AQ3, 6, $EK, 4)]],
                'akt2' => ['puan', [30, 40]],
                'akt3' => ['3A' => [$t($Q12, 2), $t($Q12, 2)], '3B' => [$t($AQ3, 3), $t($AQ3, 3)], '3C' => [$c($AQ3, 2, $EK, 3), $c($AQ3, 2, $EK, 3)]],
                'toplam' => 500,
            ],
        ],
    ],
    [
        'ad' => 'İnsan ve Toplum Bilimleri Fakültesi',
        'bolumler' => [
            ['İngilizce Mütercim ve Tercümanlık', 'filoloji'],
            ['İşletme', 'sosyal'],
            ['Psikoloji', 'sosyal'],
            ['Sosyoloji', 'sosyal'],
            ['Uluslararası İlişkiler', 'sosyal'],
            ['Uluslararası Ticaret ve Lojistik', 'sosyal'],
        ],
        'kadrolar' => [
            'dr_ogr_uyesi' => [
                'akt1' => [
                    '1A' => [null, $t($Q12, 1), $t($Q12, 1), $t($Q12, 1), $t($Q12, 1), $t($Q12, 1)],
                    '1B' => [$t($AQ3, 1), $t($AQ3, 2), $t($AQ3, 2), $t($AQ3, 2), $t($AQ3, 2), $t($AQ3, 2)],
                    '1C' => [null, $c($AQ3, 1, $EK, 3), $c($AQ3, 1, $EK, 3), $c($AQ3, 1, $EK, 3), $c($AQ3, 1, $EK, 3), $c($AQ3, 1, $EK, 3)],
                    '1D' => [$t($E14, 2), $t($E14, 3), $t($E14, 3), $t($E14, 3), $t($E14, 3), $t($E14, 3)],
                    '1E' => [$t($GEN, 5), $t($GEN, 5), $t($GEN, 5), $t($GEN, 5), $t($GEN, 5), $t($GEN, 5)],
                ],
                'akt2' => ['puan', [15, 15, 15, 15, 15, 15]],
                'akt3' => [
                    '3A' => [null, $t($Q12, 1), $t($Q12, 1), $t($Q12, 1), $t($Q12, 1), $t($Q12, 1)],
                    '3B' => [null, $c($AQ3, 1, $EK, 1), $c($AQ3, 1, $EK, 1), $c($AQ3, 1, $EK, 1), $c($AQ3, 1, $EK, 1), $c($AQ3, 1, $EK, 1)],
                    '3C' => [$t($AQ3, 1), null, null, null, null, null],
                    '3D' => [$t($E14, 3), $t($E14, 3), $t($E14, 3), $t($E14, 3), $t($E14, 3), $t($E14, 3)],
                ],
                'toplam' => 100,
            ],
            'dr_ogr_uyesi_yeniden' => [
                'akt1' => [
                    '1A' => array_fill(0, 6, $t($AQ3, 1)),
                    '1B' => array_fill(0, 6, $c($AQ3, 1, $EK, 1)),
                    '1C' => array_fill(0, 6, $t($E14, 3)),
                ],
                'akt2' => ['adet', array_fill(0, 6, 1)],
                'akt3' => [
                    '3A' => array_fill(0, 6, $t($Q12, 1)),
                    '3B' => array_fill(0, 6, $c($AQ3, 1, $EK, 1)),
                    '3C' => array_fill(0, 6, $t($E14, 2)),
                ],
                'toplam' => 150,
            ],
            'docentlik' => [
                'akt1' => [
                    '1A' => [$t($Q12, 1), $t($Q12, 2), $t($Q12, 2), $t($Q12, 2), $t($Q12, 2), $t($Q12, 2)],
                    '1B' => [$t($AQ3, 2), $t($AQ3, 3), $t($AQ3, 3), $t($AQ3, 3), $t($AQ3, 3), $t($AQ3, 3)],
                    '1C' => [$c($AQ3, 1, $EK, 5), $c($AQ3, 2, $EK, 3), $c($AQ3, 2, $EK, 3), $c($AQ3, 2, $EK, 3), $c($AQ3, 2, $EK, 3), $c($AQ3, 2, $EK, 3)],
                    '1D' => [$t($E14, 3), $t($E14, 4), $t($E14, 4), $t($E14, 4), $t($E14, 4), $t($E14, 4)],
                    '1E' => [$t($GEN, 10), null, null, null, null, null],
                ],
                'akt2' => ['puan', array_fill(0, 6, 20)],
                'akt3' => [
                    '3A' => array_fill(0, 6, $t($Q12, 1)),
                    '3B' => array_fill(0, 6, $c($AQ3, 1, $EK, 2)),
                    '3C' => array_fill(0, 6, $t($E14, 2)),
                    '3D' => array_fill(0, 6, $t($GEN, 3)),
                ],
                'toplam' => 200,
            ],
            'profesorluk' => [
                'akt1' => [
                    '1A' => [$t($Q12, 2), $t($Q12, 3), $t($Q12, 3), $t($Q12, 3), $t($Q12, 3), $t($Q12, 3)],
                    '1B' => [$t($AQ3, 3), $t($AQ3, 4), $t($AQ3, 4), $t($AQ3, 4), $t($AQ3, 4), $t($AQ3, 4)],
                    '1C' => [$c($AQ3, 2, $EK, 4), $c($AQ3, 3, $EK, 5), $c($AQ3, 3, $EK, 5), $c($AQ3, 3, $EK, 5), $c($AQ3, 3, $EK, 5), $c($AQ3, 3, $EK, 5)],
                    '1D' => [$t($E14, 5), $t($E14, 6), $t($E14, 6), $t($E14, 6), $t($E14, 6), $t($E14, 6)],
                    '1E' => [$t($GEN, 15), null, null, null, null, null],
                ],
                'akt2' => ['puan', array_fill(0, 6, 30)],
                'akt3' => [
                    '3A' => array_fill(0, 6, $t($Q12, 2)),
                    '3B' => array_fill(0, 6, $c($AQ3, 2, $EK, 2)),
                    '3C' => array_fill(0, 6, $t($E14, 3)),
                    '3D' => array_fill(0, 6, $t($GEN, 5)),
                ],
                'toplam' => 400,
            ],
        ],
    ],
    [
        'ad' => 'Mimarlık ve Tasarım Fakültesi',
        'bolumler' => [
            ['Mimarlık', 'mimarlik'],
            ['Şehir ve Bölge Planlama', 'mimarlik'],
        ],
        'kadrolar' => [
            'dr_ogr_uyesi' => [
                'akt1' => ['1A' => [$t($Q12, 1), $t($Q12, 2)], '1B' => [$t($AQ3, 2), $t($AQ3, 3)], '1C' => [$c($AQ3, 1, $EKT, 2), $c($AQ3, 2, $EKT, 2)]],
                'akt2' => ['puan', [15, 15]],
                'akt3' => ['3A' => [$t($Q12, 1), $t($Q12, 1)], '3B' => [$t($AQ3, 2), $t($AQ3, 2)], '3C' => [$c($AQ3, 1, $EKT, 3), $c($AQ3, 1, $EKT, 3)]],
                'toplam' => 100,
            ],
            'dr_ogr_uyesi_yeniden' => [
                'akt1' => ['1A' => [$t($AQ3, 1), $t($AQ3, 1)], '1B' => [$t($AQ3, 2), $t($AQ3, 2)]],
                'akt2' => ['adet', [1, 1]],
                'akt3' => ['3A' => [$t($Q12, 1), $t($Q12, 1)], '3B' => [$t($AQ3, 2), $t($AQ3, 2)]],
                'toplam' => 150,
            ],
            'docentlik' => [
                'akt1' => ['1A' => [$t($Q12, 2), $t($Q12, 3)], '1B' => [$t($AQ3, 3), $t($AQ3, 4)], '1C' => [$c($AQ3, 2, $EKT, 2), $c($AQ3, 3, $EKT, 2)]],
                'akt2' => ['puan', [25, 25]],
                'akt3' => ['3A' => [$t($Q12, 1), $t($Q12, 1)], '3B' => [$t($AQ3, 2), $t($AQ3, 2)], '3C' => [$c($AQ3, 1, $EKT, 3), $c($AQ3, 1, $EKT, 3)]],
                'toplam' => 250,
            ],
            'profesorluk' => [
                'akt1' => ['1A' => [$t($Q12, 3), $t($Q12, 4)], '1B' => [$t($AQ3, 4), $t($AQ3, 5)], '1C' => [$c($AQ3, 2, $EKT, 4), $c($AQ3, 3, $EKT, 4)]],
                'akt2' => ['puan', [35, 35]],
                'akt3' => ['3A' => [$t($Q12, 2), $t($Q12, 2)], '3B' => [$t($AQ3, 3), $t($AQ3, 3)], '3C' => [$c($AQ3, 1, $EKT, 5), $c($AQ3, 1, $EKT, 5)]],
                'toplam' => 500,
            ],
        ],
    ],
    [
        'ad' => 'Mühendislik ve Doğa Bilimleri Fakültesi (Doğa Bilimleri)',
        'bolumler' => [
            ['Fizik', 'fen'],
            ['Kimya', 'fen'],
            ['Matematik', 'fen'],
            ['Yapay Zekâ ve Makine Öğrenmesi', 'muhendislik'],
            ['Veri Bilimi ve Analitiği', 'muhendislik'],
        ],
        'kadrolar' => [
            'dr_ogr_uyesi' => [
                'akt1' => [
                    '1A' => [$t($Q12, 4), $t($Q12, 4), $t($Q12, 2), $t($Q12, 1), $t($Q12, 1)],
                    '1B' => [$t($AQ3, 5), $t($AQ3, 5), $t($AQ3, 3), $t($AQ3, 2), $t($AQ3, 2)],
                    '1C' => [$c($AQ3, 4, $EK, 2), $c($AQ3, 4, $EK, 2), $c($AQ3, 2, $EK, 2), $c($AQ3, 1, $EK, 2), $c($AQ3, 1, $EK, 2)],
                ],
                // Dipnot b: Yapay Zekâ ve Veri Bilimi bölümlerinde Aktivite 2
                // proje şartı ARANMIYOR.
                'akt2' => ['puan', [20, 20, 20, null, null]],
                'akt3' => [
                    '3A' => [$t($Q12, 1), $t($Q12, 1), null, null, null],
                    '3B' => [$t($AQ3, 2), $t($AQ3, 2), $t($AQ3, 1), null, null],
                    '3C' => [$c($AQ3, 1, $EK, 3), $c($AQ3, 1, $EK, 3), $t($EK, 3), null, null],
                ],
                'toplam' => 100,
            ],
            'dr_ogr_uyesi_yeniden' => [
                'akt1' => [
                    '1A' => [$t($AQ3, 3), $t($AQ3, 3), $t($AQ3, 2), $t($AQ3, 2), $t($AQ3, 2)],
                    '1B' => [$c($AQ3, 2, $EK, 3), $c($AQ3, 2, $EK, 3), $c($AQ3, 1, $EK, 3), $c($AQ3, 1, $EK, 3), $c($AQ3, 1, $EK, 3)],
                ],
                'akt2' => ['adet', [1, 1, 1, 1, 1]],
                'akt3' => [
                    '3B' => [$t($AQ3, 2), $t($AQ3, 2), $t($AQ3, 1), $t($AQ3, 1), $t($AQ3, 1)],
                    '3C' => [$c($AQ3, 1, $EK, 2), $c($AQ3, 1, $EK, 2), $c($AQ3, 1, $EK, 2), $c($AQ3, 1, $EK, 2), $c($AQ3, 1, $EK, 2)],
                ],
                'toplam' => 150,
            ],
            'docentlik' => [
                'akt1' => [
                    '1A' => [$t($Q12, 7), $t($Q12, 7), $t($Q12, 4), $t($Q12, 2), $t($Q12, 2)],
                    '1B' => [$t($AQ3, 8), $t($AQ3, 8), $t($AQ3, 6), $t($AQ3, 3), $t($AQ3, 3)],
                    '1C' => [$c($AQ3, 7, $EK, 2), $c($AQ3, 7, $EK, 2), $c($AQ3, 5, $EK, 2), $c($AQ3, 2, $EK, 2), $c($AQ3, 2, $EK, 2)],
                ],
                'akt2' => ['puan', [30, 30, 30, null, null]],
                'akt3' => [
                    '3A' => [$t($Q12, 1), $t($Q12, 1), null, null, null],
                    '3B' => [$t($AQ3, 2), $t($AQ3, 2), $t($AQ3, 1), $t($AQ3, 1), $t($AQ3, 1)],
                    '3C' => [$c($AQ3, 1, $EK, 3), $c($AQ3, 1, $EK, 3), $t($EK, 3), $t($EK, 3), $t($EK, 3)],
                ],
                'toplam' => 250,
            ],
            'profesorluk' => [
                'akt1' => [
                    '1A' => [$t($Q12, 10), $t($Q12, 10), $t($Q12, 6), $t($Q12, 4), $t($Q12, 4)],
                    '1B' => [$t($AQ3, 11), $t($AQ3, 11), $t($AQ3, 7), $t($AQ3, 5), $t($AQ3, 5)],
                    '1C' => [$c($AQ3, 10, $EK, 2), $c($AQ3, 10, $EK, 2), $c($AQ3, 6, $EK, 2), $c($AQ3, 4, $EK, 2), $c($AQ3, 4, $EK, 2)],
                ],
                'akt2' => ['puan', [40, 40, 40, null, null]],
                'akt3' => [
                    '3A' => [$t($Q12, 2), $t($Q12, 2), $t($Q12, 1), $t($Q12, 1), $t($Q12, 1)],
                    '3B' => [$t($AQ3, 3), $t($AQ3, 3), $t($AQ3, 2), $t($AQ3, 2), $t($AQ3, 2)],
                    '3C' => [$c($AQ3, 2, $EK, 3), $c($AQ3, 2, $EK, 3), $c($AQ3, 1, $EK, 3), $c($AQ3, 1, $EK, 3), $c($AQ3, 1, $EK, 3)],
                ],
                'toplam' => 500,
            ],
        ],
    ],
    [
        'ad' => 'Mühendislik ve Doğa Bilimleri Fakültesi (Mühendislik)',
        'bolumler' => [
            ['Bilgisayar Mühendisliği', 'muhendislik'],
            ['Biyomühendislik', 'muhendislik'],
            ['Çevre Mühendisliği', 'muhendislik'],
            ['Elektrik-Elektronik Mühendisliği', 'muhendislik'],
            ['Endüstri Mühendisliği', 'muhendislik'],
            ['Gıda Mühendisliği', 'muhendislik'],
            ['Havacılık ve Uzay Mühendisliği', 'muhendislik'],
            ['İnşaat Mühendisliği', 'muhendislik'],
            ['Kimya Mühendisliği', 'muhendislik'],
            ['Makine Mühendisliği', 'muhendislik'],
            ['Mekatronik Mühendisliği', 'muhendislik'],
            ['Metalurji ve Malzeme Mühendisliği', 'muhendislik'],
            ['Polimer Malzeme Mühendisliği', 'muhendislik'],
        ],
        'kadrolar' => [
            'dr_ogr_uyesi' => [
                'akt1' => [
                    '1A' => array_map(fn (int $n): array => $t($Q12, $n), [2, 6, 5, 3, 3, 5, 3, 3, 4, 3, 3, 3, 4]),
                    '1B' => array_map(fn (int $n): array => $t($Q13, $n), [3, 8, 7, 4, 4, 7, 4, 4, 6, 5, 4, 5, 6]),
                    '1C' => array_map(fn (array $p): array => $c($Q13, $p[0], $EK, $p[1]), [[2, 3], [7, 2], [6, 2], [3, 2], [3, 2], [6, 2], [3, 2], [3, 2], [5, 2], [3, 2], [3, 2], [4, 2], [5, 2]]),
                ],
                'akt2' => ['puan', array_fill(0, 13, 20)],
                'akt3' => [
                    '3A' => array_fill(0, 13, $t($Q12, 1)),
                    '3B' => array_fill(0, 13, $t($Q13, 2)),
                    '3C' => array_fill(0, 13, $c($Q13, 1, $EK, 3)),
                ],
                'toplam' => 100,
            ],
            'dr_ogr_uyesi_yeniden' => [
                'akt1' => [
                    '1A' => array_map(fn (int $n): array => $t($Q13, $n), [2, 3, 3, 3, 2, 3, 2, 2, 3, 2, 2, 3, 3]),
                    '1B' => array_map(fn (array $p): array => $c($Q13, $p[0], $EK, $p[1]), [[1, 3], [2, 3], [2, 3], [2, 3], [1, 3], [2, 3], [1, 3], [1, 3], [2, 3], [1, 3], [1, 3], [2, 3], [2, 3]]),
                ],
                'akt2' => ['adet', array_fill(0, 13, 1)],
                'akt3' => [
                    '3A' => array_fill(0, 13, $t($Q13, 2)),
                    '3B' => array_fill(0, 13, $c($Q13, 1, $EK, 2)),
                ],
                'toplam' => 150,
            ],
            'docentlik' => [
                'akt1' => [
                    '1A' => array_map(fn (int $n): array => $t($Q12, $n), [3, 8, 7, 4, 5, 7, 4, 5, 6, 5, 4, 6, 7]),
                    '1B' => array_map(fn (int $n): array => $t($Q13, $n), [5, 10, 9, 6, 7, 9, 6, 6, 8, 7, 6, 8, 9]),
                    '1C' => array_map(fn (array $p): array => $c($Q13, $p[0], $EK, $p[1]), [[4, 2], [9, 2], [8, 2], [5, 2], [5, 4], [8, 2], [5, 2], [5, 2], [5, 4], [5, 4], [5, 2], [5, 4], [8, 2]]),
                ],
                'akt2' => ['puan', array_fill(0, 13, 30)],
                'akt3' => [
                    '3A' => array_fill(0, 13, $t($Q12, 1)),
                    '3B' => array_fill(0, 13, $t($Q13, 2)),
                    '3C' => array_fill(0, 13, $c($Q13, 1, $EK, 3)),
                ],
                'toplam' => 250,
            ],
            'profesorluk' => [
                'akt1' => [
                    '1A' => array_map(fn (int $n): array => $t($Q12, $n), [5, 12, 10, 6, 7, 10, 6, 7, 10, 9, 6, 9, 10]),
                    '1B' => array_map(fn (int $n): array => $t($Q13, $n), [6, 14, 12, 8, 9, 12, 8, 9, 11, 10, 8, 11, 12]),
                    '1C' => array_map(fn (array $p): array => $c($Q13, $p[0], $EK, $p[1]), [[5, 3], [13, 2], [11, 2], [7, 2], [8, 2], [11, 2], [7, 2], [8, 2], [10, 2], [9, 2], [7, 2], [10, 2], [11, 2]]),
                ],
                'akt2' => ['puan', array_fill(0, 13, 40)],
                'akt3' => [
                    '3A' => array_fill(0, 13, $t($Q12, 2)),
                    '3B' => array_fill(0, 13, $t($Q13, 3)),
                    '3C' => array_fill(0, 13, $c($Q13, 2, $EK, 3)),
                ],
                'toplam' => 500,
            ],
        ],
    ],
    [
        'ad' => 'Orman Fakültesi',
        'bolumler' => [
            ['Orman Endüstri Mühendisliği', 'ziraat'],
            ['Orman Mühendisliği', 'ziraat'],
            ['Peyzaj Mimarlığı', 'mimarlik'],
        ],
        'kadrolar' => [
            'dr_ogr_uyesi' => [
                'akt1' => [
                    '1A' => [$t($Q12, 3), $t($Q12, 3), $t($Q12, 2)],
                    '1B' => [$t($AQ3, 4), $t($AQ3, 4), $t($AQ3, 3)],
                    '1C' => [$c($AQ3, 3, $EK, 3), $c($AQ3, 3, $EK, 3), null],
                    '1D' => [null, null, $c($AQ3, 2, $EKT, 2)],
                ],
                'akt2' => ['puan', [20, 20, 15]],
                'akt3' => [
                    '3A' => [$t($Q12, 1), $t($Q12, 1), $t($Q12, 1)],
                    '3B' => [$t($AQ3, 2), $t($AQ3, 2), $t($AQ3, 2)],
                    '3C' => [$c($AQ3, 1, $EK, 3), $c($AQ3, 1, $EK, 3), null],
                    '3D' => [null, null, $c($AQ3, 1, $EKT, 3)],
                ],
                'toplam' => 100,
            ],
            'dr_ogr_uyesi_yeniden' => [
                'akt1' => ['1A' => [$t($AQ3, 2), $t($AQ3, 2), $t($AQ3, 1)]],
                'akt2' => ['adet', [1, 1, 1]],
                'akt3' => [
                    '3A' => [$t($Q12, 1), $t($Q12, 1), null],
                    '3B' => [null, null, $t($AQ3, 1)],
                ],
                'toplam' => 150,
            ],
            'docentlik' => [
                'akt1' => [
                    '1A' => [$t($Q12, 4), $t($Q12, 4), $t($Q12, 3)],
                    '1B' => [$t($AQ3, 6), $t($AQ3, 6), $t($AQ3, 4)],
                    '1C' => [$c($AQ3, 5, $EK, 2), $c($AQ3, 5, $EK, 2), null],
                    '1D' => [null, null, $c($AQ3, 3, $EKT, 2)],
                ],
                'akt2' => ['puan', [30, 30, 20]],
                'akt3' => [
                    '3A' => [$t($Q12, 1), $t($Q12, 1), $t($Q12, 1)],
                    '3B' => [$t($AQ3, 2), $t($AQ3, 2), $t($AQ3, 2)],
                    '3C' => [$c($AQ3, 1, $EK, 3), $c($AQ3, 1, $EK, 3), null],
                    '3D' => [null, null, $c($AQ3, 1, $EKT, 3)],
                ],
                'toplam' => 250,
            ],
            'profesorluk' => [
                'akt1' => [
                    '1A' => [$t($Q12, 6), $t($Q12, 6), $t($Q12, 4)],
                    '1B' => [$t($AQ3, 8), $t($AQ3, 8), $t($AQ3, 5)],
                    '1C' => [$c($AQ3, 7, $EK, 4), $c($AQ3, 7, $EK, 4), null],
                    '1D' => [null, null, $c($AQ3, 3, $EKT, 4)],
                ],
                'akt2' => ['puan', [40, 40, 30]],
                'akt3' => [
                    '3A' => [$t($Q12, 2), $t($Q12, 2), $t($Q12, 2)],
                    '3B' => [$t($AQ3, 3), $t($AQ3, 3), $t($AQ3, 3)],
                    '3C' => [$c($AQ3, 2, $EK, 3), $c($AQ3, 2, $EK, 3), null],
                    '3D' => [null, null, $c($AQ3, 1, $EKT, 5)],
                ],
                'toplam' => 500,
            ],
        ],
    ],
];

$esikler = [];

/** Bölüm adından anahtar üretir. */
$slug = function (string $ad): string {
    $tr = ['ı' => 'i', 'İ' => 'i', 'ş' => 's', 'Ş' => 's', 'ğ' => 'g', 'Ğ' => 'g',
        'ü' => 'u', 'Ü' => 'u', 'ö' => 'o', 'Ö' => 'o', 'ç' => 'c', 'Ç' => 'c', 'â' => 'a', 'Â' => 'a'];
    $s = mb_strtolower(strtr($ad, $tr), 'UTF-8');

    return trim((string) preg_replace('/-+/', '-', (string) preg_replace('/[^a-z0-9]+/', '-', $s)), '-');
};

foreach ($FAKULTELER as $fakulte) {
    foreach ($fakulte['bolumler'] as $i => [$bolumAdi, $alan]) {
        foreach ($fakulte['kadrolar'] as $kadro => $tablo) {
            $kad = $KADROLAR[$kadro];
            $donem = $kad['donem'];
            // Dr. ilk atanmada dönem koşulu yok; diğerlerinde MADDE 6/l-n-o.
            $yariDonem = $kadro === 'dr_ogr_uyesi' ? null : $donem;

            $cocuklar = [];

            if ($kad['yds']) {
                $cocuklar[] = Kalip::yds(55);
            }

            if ($kadro === 'dr_ogr_uyesi') {
                $cocuklar[] = Kalip::beyan('Doktora ya da tıpta, diş hekimliğinde, eczacılıkta veya veteriner hekimlikte uzmanlık unvanına sahip olmak', 'Madde 5');
            } elseif ($kadro !== 'dr_ogr_uyesi_yeniden') {
                $cocuklar[] = Kalip::beyan('Üniversitelerarası Kurul tarafından verilen doçentlik unvanına sahip olmak', 'Madde 5');
            } else {
                $cocuklar[] = Kalip::beyan('Doçentlik unvanını almış doktor öğretim üyeleri yeniden atanmada yalnızca doçentlik belgelerini sunar; bu durumda aşağıdaki ek şartlar aranmaz', 'Madde 6/m');
            }

            // ── Aktivite 1 ─────────────────────────────────────────────
            $akt1 = [];

            // Hücre dizi değilse kaynakta "-" var demektir: o kod bu bölümde yok.
            foreach ((array) $tablo['akt1'] as $kod => $hucreler) {
                $hucre = is_array($hucreler) ? ($hucreler[$i] ?? null) : null;

                if (! is_array($hucre)) {
                    continue;
                }
                $akt1[] = $kodDugumu($hucre, $yariDonem, "Tablo 1 Aktivite 1/{$kod}");
            }

            $cocuklar[] = count($akt1) === 1
                ? $akt1[0]
                : Kalip::veya('Yayın ölçütlerinden en az birini sağlamalısınız', $akt1);

            // ── Aktivite 2 VEYA Aktivite 3 ─────────────────────────────
            [$akt2Tip, $akt2Degerler] = (array) $tablo['akt2'];
            $akt2Ham = is_array($akt2Degerler) ? ($akt2Degerler[$i] ?? null) : null;
            // Kaynakta bu bölüm için Aktivite 2 aranmıyorsa hücre boştur.
            $akt2Deger = is_int($akt2Ham) ? $akt2Ham : null;

            $akt3 = [];

            foreach ((array) ($tablo['akt3'] ?? []) as $kod => $hucreler) {
                $hucre = is_array($hucreler) ? ($hucreler[$i] ?? null) : null;

                if (! is_array($hucre)) {
                    continue;
                }
                $akt3[] = $kodDugumu($hucre, $yariDonem, "Tablo 1 Aktivite 3/{$kod}");
            }

            if ($akt2Deger !== null) {
                $akt2 = $akt2Tip === 'puan'
                    ? Kalip::puanDan(
                        "Proje kalemlerinizden en az {$akt2Deger} puan",
                        ['PROJE-ODUL'], $akt2Deger, $yariDonem, madde: 'Tablo 1 Aktivite 2',
                    )
                    : Kalip::adet(
                        'TÜBİTAK, Avrupa Birliği ya da diğer fon sağlayan kurumların desteklediği en az 1 projede görev almış olmalısınız',
                        ['PROJE'], $akt2Deger, donem: $donem, madde: 'Tablo 1 Aktivite 2',
                    );

                if ($akt3 === []) {
                    $cocuklar[] = $akt2;
                } else {
                    $alternatif = count($akt3) === 1
                        ? $akt3[0]
                        : Kalip::veya('Proje alternatifi yayın ölçütleri', $akt3);
                    $cocuklar[] = Kalip::veya(
                        'Proje ölçütünü ya da onun yayın alternatifini sağlamalısınız',
                        [$akt2, $alternatif],
                    );
                }
            }

            // ── Aktivite 4 (alt ölçüt sayımı) ──────────────────────────
            if ($kad['k'] !== null) {
                $cocuklar[] = Kalip::kIle(
                    "Diğer aktivite ölçütlerinden en az {$kad['k']}'ini sağlamalısınız",
                    $kad['k'], $aktivite4($donem),
                );
            }

            // ── Aktivite 4/5 (toplam puan) ─────────────────────────────
            $toplam = (int) $tablo['toplam'];
            $cocuklar[] = Kalip::toplam($toplam);

            if ($kadro === 'dr_ogr_uyesi_yeniden') {
                // Aktivite 5: 150 puanın en az 50'si yeniden atanma dönemi içinde.
                $cocuklar[] = Kalip::toplam(50, $donem);
            } elseif ($yariDonem !== null) {
                $cocuklar[] = Kalip::toplam(intdiv($toplam, 2), $yariDonem);
            }

            $esikler[] = [
                'anahtar' => 'bursa-teknik-'.$slug($bolumAdi).'-'.str_replace('_', '-', $kadro),
                'aday_notu' => 'Bursa Teknik\'in ölçütleri BÖLÜM BÖLÜM değişiyor; burada '
                    ."{$bolumAdi} bölümünün tablosu uygulanıyor. Yayın ölçütlerinden en az "
                    .'birini sağlamanız, ardından proje ölçütünü ya da onun yayın alternatifini '
                    .'tamamlamanız ve tüm faaliyetlerinizden toplam '.$toplam.' puan almanız '
                    .'gerekiyor. Sayı istenen her ölçütte, o sayının yarısında başlıca yazar '
                    .'olmanız da aranıyor.'
                    .($kad['k'] !== null ? ' Ayrıca on altı "diğer aktivite" ölçütünden en az '.$kad['k'].'\'ini sağlamalısınız.' : '')
                    .' DİKKAT: yönerge bu kadro için biri "yurt dışı/kurum dışı araştırma '
                    .'tecrübesi mevcut", biri "mevcut değil" olmak üzere iki ayrı tablo veriyor. '
                    .'Bu tecrübe (kesintisiz dokuz aylık yurt dışı ya da burslu kurum dışı '
                    .'araştırma ve ondan çıkan bir WoS Q1-Q3 yayın kabulü) profilde '
                    .'tutulmadığı için burada ZOR olan "mevcut değil" tablosu uygulanıyor; '
                    .'bu tecrübeye sahipseniz gerçek eşiğiniz buradakinden düşüktür. '
                    .'Ayrıca "diğer aktivite" ölçütlerinden beşi (idari görev süresi, açık '
                    .'kaynak yazılım, h-indeksi, proje başvurusu, ortak dersler bölümünde ders) '
                    .'faaliyet kaydından hesaplanamadığı için sayıma girmiyor.',
                'universite' => $UNIVERSITE,
                'kadro' => $kadro,
                'alan' => [$alan],
                'birim' => $bolumAdi,
                'cetvel' => $CETVEL,
                'notlar' => "{$fakulte['ad']} — {$bolumAdi}, {$kad['ad']} (Tablo 1, tecrübe "
                    .'mevcut değil varyantı). Aktivite 1 yayın adetleri bölüm sütunundan; '
                    .'Aktivite 2 '.($akt2Deger === null ? 'ARANMIYOR (dipnot b)' : ($akt2Tip === 'puan' ? "{$akt2Deger} puan" : "{$akt2Deger} proje"))
                    .'; Aktivite '.($kad['k'] === null ? '4' : '5')." toplam {$toplam} puan"
                    .($kad['k'] !== null ? "; Aktivite 4 en az {$kad['k']} alt ölçüt (16'nın 11'i değerlendirilebiliyor)" : '')
                    .'.',
                'sart' => Kalip::ve("{$kad['ad']} — {$bolumAdi}", $cocuklar),
            ];
        }
    }
}

return $esikler;
