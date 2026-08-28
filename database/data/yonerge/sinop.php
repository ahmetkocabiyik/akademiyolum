<?php

/**
 * SİNOP ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma Ölçütleri
 * Yönergesi
 * Kaynak: pdf/17537008012.sinopuniverstesi.pdf (88 sayfa; SNÜ-YNG-011,
 * Senato 15.01.2025-2025/09, değişiklikler 16.01.2025-2025/11 ve
 * 03.06.2025-2025/71; YÖK'ün 28/05/2025 tarihli E.349314 yazısı ile
 * uygun görülüp MADDE 11 uyarınca 01.10.2025'te yürürlüğe girdi.)
 *
 * ── YAPI ──
 * Madde 8(1) başvuruları ÜAK temel alanlarına göre ayırıyor ve EK-1-12
 * her temel alana kendi tablosunu veriyor. Her tablonun "Akademik kadro
 * atamaları için gerekli olan asgari puanlar" başlığı dört kadronun
 * toplam puan barajını, tablonun sütunları da madde madde zorunlu
 * şartları veriyor. Zorunlu şart konan maddeler kadroya göre değişiyor
 * (Eğitim Bilimlerinde doçentlik için 1, 4, 6, 7 ve 8; Hukukta 1, 3, 5
 * ve 7 gibi); yalnız o maddelerin koşulları eşiğe yazıldı.
 *
 * ── YABANCI DİL VE MUAFİYETİ ──
 * Madde 8(2): doktor öğretim üyeliği YENİDEN atamaları dışında bütün
 * atamalarda merkezi yabancı dil sınavından en az 60 puan gerekiyor.
 * Doçent ve profesör atamalarında SCIE, SSCI, AHCI ya da Scopus
 * kapsamındaki bir dergide en az bir makale yayımlayan adaydan bu şart
 * aranmıyor; koşul `veya` düğümü olarak yazıldı. Yalnızca yabancı dilde
 * öğretim yapılan programlarda 85 puan isteniyor — profil bölümün
 * öğretim dilini tutmadığı için §0 uyarınca 60 uygulandı, 85 aday
 * notunda.
 *
 * ── GÜZEL SANATLAR EŞİĞİ YOK ──
 * Tablo GS2'nin (Sanatsal Faaliyetler) satırları tek esere değil
 * dosyaya puan veriyor ve Güzel Sanatlar temel alanının BÜTÜN
 * kadrolarında GS2'den asgari puan zorunlu. Koşulun tamamı girilemeyen
 * bir tabloya dayandığı için §0 uyarınca bu alanda hiç eşik yazılmadı.
 *
 * ── UYGULANMAYAN MUAFİYET YOLLARI ──
 * Her tablonun "Puanlama kriterleri ile ilgili açıklamalar" başlığı
 * altında muafiyetler var ve hepsi TELAFİ yönünde:
 *   Yeniden atanmada makale bölümünden en az 3 yayın yapanın proje
 *       zorunluluğundan muaf tutulması.
 *   Yürütücü olarak tamamlanmış TÜBİTAK 1001 projesi, tescilli patent ya
 *       da ödül belgeleyenin bütün zorunlu şartlardan muaf tutulması.
 *   Tek yazarlı ya da danışmanlığını yaptığı öğrencisiyle yazılmış en az
 *       3 Q1 makalesi olanın doçentlik ve profesörlükte bütün zorunlu
 *       şartlardan muaf tutulması.
 *   Makale koşulunu sağlayamayanın proje, projeyi sağlayamayanın makale
 *       koşuluyla telafi etmesi (Filoloji, Hukuk, İlahiyat, Mimarlık,
 *       Sosyal tablolarında).
 *   Müzik Eğitimi ve Resim-İş Eğitimi adaylarının Tablo GS2'den 30 puana
 *       kadar puan alabilmesi.
 * §0 uyarınca hiçbiri girilmedi: eşik olduğundan zor görünür, aday
 * olduğundan hazır görünmez. Aday notunda tek tek söyleniyor.
 *
 * ── GEÇİŞ HÜKMÜ ──
 * Geçici Madde 1 yürürlük tarihinde yeniden atanma tarihine bir yıldan
 * az kalanlara toplam puanın 1/3'ünü, iki yıldan az kalanlara 2/3'ünü
 * uyguluyor. Eşiğe TAM puan yazıldı; indirim aday notunda.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   Madde 8(4): profesör kadrolarında ÜAK'ın yürürlükteki doçentlik
 *       temel alan şartlarının bir kez daha sağlanması — ÜAK'ın kendi
 *       cetveline bağlı, `hesaplanamiyor`.
 *   Madde 8(8): bir çalışmanın iki ayrı muafiyette kullanılamaması.
 *   Madde 8(9)-(10): eserlerin yayımlanmış olması, DOI ve indeks
 *       belgelendirme koşulları.
 *   Fen Bilimlerinde matematik ve istatistik bilim alanlarına tanınan
 *       düşük makale eşikleri (doçentlikte 25, profesörlükte 20) —
 *       profil bilim dalını tutmadığı için diğer bilim alanlarının
 *       yüksek eşiği (45 ve 40) uygulandı.
 *   Profesörlükte projede "yürütücü veya danışman olmak" koşulu
 *       uluslararası destekli ve kamu/özel kuruluş projelerinde ancak
 *       rol girilmişse sayılıyor.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/sinop-2025.php
 */

use App\Services\Scoring\Sart\Kalip;

$UNIVERSITE = 'Sinop Üniversitesi';
$DOKTORA = Kalip::DOKTORA_SONRASI;
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;
$SON_ATAMA = Kalip::SON_ATAMA_SONRASI;

$SCI = 'SCIE ya da SSCI kapsamındaki dergilerde';
$SCI123 = 'SCIE ya da SSCI kapsamındaki Q1, Q2 veya Q3 dergilerde';
$Q12 = 'SCIE ya da SSCI kapsamındaki Q1 veya Q2 dergilerde';
$ABC = 'SCIE, SSCI, AHCI, ESCI ya da Scopus kapsamındaki dergilerde';
$ABCD = 'SCIE, SSCI, AHCI, ESCI, Scopus ya da TR Dizin kapsamındaki dergilerde';
$HAKEMLI = 'hakemli dergilerde';
$KITAP = 'BKCI kapsamındaki ya da bir yayınevi tarafından yayımlanmış kitaplardan';

$NOT_MUAFIYET = ' Yönergenin muafiyet yolları UYGULANMIYOR: yürütücü olarak tamamladığınız bir '
    .'TÜBİTAK 1001 projesi, tescilli bir patent ya da yönergede sayılan ödüllerden biri; '
    .'doçentlik ve profesörlükte tek yazarlı veya danışmanlığını yaptığınız öğrencinizle '
    .'yazdığınız en az üç Q1 makalesi; makale koşulunu sağlayamayanlar için proje, proje '
    .'koşulunu sağlayamayanlar için makale telafisi. Bunlardan biri sizde varsa koşullar '
    .'burada göründüğünden kolaydır.';
$NOT_DIL = ' Yabancı dil koşulu 60 puandan uygulanıyor; yalnızca yabancı dilde öğretim yapılan '
    .'programlara başvuruyorsanız 85 puan gerekiyor.';
$NOT_TAVAN = ' Aynı dergideki en fazla üç çalışmanın, aynı bilimsel toplantıdaki en fazla iki '
    .'çalışmanın ve aynı kitaptaki tek bölümün puanlanması kuralları motorda yok; bu '
    .'kalemlerde puanınız yüksek görünebilir.';

/**
 * Temel alan tabloları. Her kadro için tablonun ZORUNLU şart konan
 * maddeleri; anahtarlar cetveldeki madde kümelerine karşılık geliyor.
 */
$ALANLAR = [
    // ── A ailesi ──
    'egitim' => [
        'ad' => 'Eğitim Bilimleri',
        'dr' => ['makale_adet' => [$SCI, 'MAKALE-A', 2], 'bildiri_adet' => 1, 'toplam' => 20],
        'yen' => ['makale_adet' => [$ABC, 'MAKALE-ABC', 2], 'proje' => 'her', 'bildiri' => 4, 'egitim' => 5, 'toplam' => 45],
        'doc' => ['makale_puan' => [$SCI123, 'MAKALE-A-NOQ4', 35], 'atif' => 15, 'proje' => 'abcd', 'bildiri' => 6, 'egitim' => 5, 'toplam' => 110],
        'prof' => ['prof_q' => [$Q12, 'MAKALE-Q12', 3], 'prof_alt' => [$SCI123, 'MAKALE-A-NOQ4', 30], 'atif' => 30, 'proje' => 'yd', 'bildiri' => 8, 'egitim' => 5, 'toplam' => 130],
    ],
    'fen' => [
        'ad' => 'Fen Bilimleri ve Matematik',
        'dr' => ['makale_adet' => [$SCI, 'MAKALE-A', 2], 'bildiri_adet' => 1, 'toplam' => 20],
        'yen' => ['makale_adet' => [$ABC, 'MAKALE-ABC', 2], 'proje' => 'her', 'bildiri' => 4, 'toplam' => 50],
        'doc' => ['makale_puan' => [$SCI123, 'MAKALE-A-NOQ4', 45], 'atif' => 15, 'proje' => 'abcd', 'bildiri' => 6, 'toplam' => 110],
        'prof' => ['prof_q' => [$Q12, 'MAKALE-Q12', 4], 'prof_alt' => [$SCI123, 'MAKALE-A-NOQ4', 40], 'atif' => 30, 'proje' => 'yd', 'bildiri' => 8, 'toplam' => 140],
    ],
    'muhendislik' => [
        'ad' => 'Mühendislik',
        'dr' => ['makale_adet' => [$SCI, 'MAKALE-A', 2], 'bildiri_adet' => 1, 'toplam' => 20],
        'yen' => ['makale_adet' => [$ABC, 'MAKALE-ABC', 2], 'proje' => 'her', 'bildiri' => 4, 'toplam' => 55],
        'doc' => ['makale_puan' => [$SCI123, 'MAKALE-A-NOQ4', 45], 'atif' => 30, 'proje' => 'abcd', 'bildiri' => 6, 'toplam' => 120],
        'prof' => ['prof_q' => [$Q12, 'MAKALE-Q12', 4], 'prof_alt' => [$SCI123, 'MAKALE-A-NOQ4', 40], 'atif' => 45, 'proje' => 'yd', 'bildiri' => 8, 'toplam' => 150],
    ],
    'saglik' => [
        'ad' => 'Sağlık Bilimleri',
        'dr' => ['makale_adet' => [$SCI, 'MAKALE-A', 2], 'bildiri_adet' => 1, 'toplam' => 20],
        'yen' => ['makale_adet' => [$ABC, 'MAKALE-ABC', 2], 'proje' => 'her', 'bildiri' => 4, 'toplam' => 40],
        'doc' => ['makale_baslica' => [$SCI123, 'MAKALE-A-NOQ4', 3], 'makale_puan' => [$ABC, 'MAKALE-ABC', 45], 'atif' => 15, 'proje' => 'abcd', 'bildiri' => 6, 'toplam' => 110],
        'prof' => ['prof_q' => [$Q12, 'MAKALE-Q12', 3], 'prof_alt' => [$SCI123, 'MAKALE-A-NOQ4', 40], 'atif' => 30, 'proje' => 'yd', 'bildiri' => 8, 'toplam' => 130],
    ],
    'spor' => [
        'ad' => 'Spor Bilimleri',
        'dr' => ['makale_adet' => [$SCI, 'MAKALE-A', 2], 'bildiri_adet' => 1, 'toplam' => 20],
        'yen' => ['makale_adet' => [$ABC, 'MAKALE-ABC', 2], 'proje' => 'her', 'bildiri' => 4, 'toplam' => 50],
        'doc' => ['makale_baslica' => [$SCI123, 'MAKALE-A-NOQ4', 2], 'makale_puan' => [$ABC, 'MAKALE-ABC', 35], 'atif' => 30, 'proje' => 'abcd', 'bildiri' => 6, 'toplam' => 110],
        'prof' => ['prof_q' => [$Q12, 'MAKALE-Q12', 3], 'prof_alt' => [$SCI123, 'MAKALE-A-NOQ4', 30], 'atif' => 45, 'proje' => 'yd', 'bildiri' => 8, 'toplam' => 140],
    ],
    'ziraat' => [
        'ad' => 'Ziraat, Orman ve Su Ürünleri',
        'dr' => ['makale_adet' => [$SCI, 'MAKALE-A', 2], 'bildiri_adet' => 1, 'toplam' => 20],
        'yen' => ['makale_adet' => [$ABC, 'MAKALE-ABC', 2], 'proje' => 'her', 'bildiri' => 4, 'toplam' => 50],
        'doc' => ['makale_puan' => [$SCI123, 'MAKALE-A-NOQ4', 35], 'atif' => 15, 'proje' => 'abcd', 'bildiri' => 6, 'toplam' => 110],
        'prof' => ['prof_q' => [$Q12, 'MAKALE-Q12', 3], 'prof_alt' => [$SCI123, 'MAKALE-A-NOQ4', 30], 'atif' => 30, 'proje' => 'yd', 'bildiri' => 8, 'toplam' => 140],
    ],
    // ── B ailesi ──
    'filoloji' => [
        'ad' => 'Filoloji',
        'dr' => ['makale_adet' => [$ABCD, 'MAKALE-ABCD', 2], 'bildiri_adet' => 1, 'toplam' => 20],
        'yen' => ['makale_adet' => [$ABCD, 'MAKALE-ABCD', 2], 'proje' => 'her', 'bildiri' => 4, 'egitim' => 5, 'toplam' => 45],
        'doc' => ['makale_puan' => [$ABC, 'MAKALE-ABC', 10], 'atif' => 10, 'proje' => 'abcd', 'bildiri' => 6, 'egitim' => 5, 'toplam' => 110],
        'prof' => ['prof_q' => [$SCI123, 'MAKALE-Q123', 2], 'prof_alt' => [$ABC, 'MAKALE-ABC', 10], 'prof_alt2' => [$HAKEMLI, 'MAKALE', 45], 'kitap' => [$KITAP, 'KITAP-AC', 20], 'atif' => 10, 'proje' => 'yd', 'bildiri' => 8, 'egitim' => 5, 'toplam' => 120],
    ],
    'hukuk' => [
        'ad' => 'Hukuk',
        'dr' => ['makale_adet' => [$ABCD, 'MAKALE-ABCD', 2], 'bildiri_adet' => 1, 'toplam' => 20],
        'yen' => ['makale_adet' => [$ABCD, 'MAKALE-ABCD', 2], 'proje' => 'her', 'bildiri' => 4, 'egitim' => 5, 'toplam' => 45],
        'doc' => ['makale_puan' => [$ABCD, 'MAKALE-ABCD', 60], 'atif' => 10, 'proje' => 'abcd', 'egitim' => 5, 'toplam' => 110],
        'prof' => ['prof_q' => [$SCI123, 'MAKALE-Q123', 2], 'prof_alt' => [$ABCD, 'MAKALE-ABCD', 55], 'kitap' => [$KITAP, 'KITAP-AC', 20], 'atif' => 10, 'proje' => 'yd', 'bildiri' => 8, 'egitim' => 5, 'toplam' => 120],
    ],
    'ilahiyat' => [
        'ad' => 'İlahiyat',
        'dr' => ['makale_adet' => [$ABCD, 'MAKALE-ABCD', 2], 'bildiri_adet' => 1, 'toplam' => 20],
        'yen' => ['makale_adet' => [$ABCD, 'MAKALE-ABCD', 2], 'proje' => 'her', 'bildiri' => 4, 'egitim' => 5, 'toplam' => 45],
        'doc' => ['makale_puan' => [$ABC, 'MAKALE-ABC', 10], 'atif' => 10, 'proje' => 'abcd', 'bildiri' => 6, 'egitim' => 5, 'toplam' => 110],
        'prof' => ['prof_q' => [$SCI123, 'MAKALE-Q123', 2], 'prof_alt' => [$ABC, 'MAKALE-ABC', 10], 'prof_alt2' => [$HAKEMLI, 'MAKALE', 45], 'kitap' => [$KITAP, 'KITAP-AC', 20], 'atif' => 10, 'proje' => 'yd', 'bildiri' => 8, 'egitim' => 5, 'toplam' => 120],
    ],
    'mimarlik' => [
        'ad' => 'Mimarlık, Planlama ve Tasarım',
        'dr' => ['makale_adet' => [$ABC, 'MAKALE-ABC', 2], 'bildiri_adet' => 1, 'toplam' => 20],
        'yen' => ['makale_adet' => [$ABCD, 'MAKALE-ABCD', 2], 'proje' => 'her', 'bildiri' => 4, 'egitim' => 5, 'toplam' => 45],
        'doc' => ['makale_puan' => [$ABC, 'MAKALE-ABC', 25], 'makale_puan2' => [$HAKEMLI, 'MAKALE', 35], 'atif' => 5, 'proje' => 'abcd', 'bildiri' => 6, 'egitim' => 5, 'tasarim' => 15, 'toplam' => 120],
        'prof' => ['prof_q' => [$Q12, 'MAKALE-Q12', 3], 'prof_alt' => [$SCI, 'MAKALE-A', 20], 'atif' => 10, 'proje' => 'yd', 'bildiri' => 8, 'egitim' => 5, 'tasarim' => 20, 'toplam' => 120],
    ],
    'sosyal' => [
        'ad' => 'Sosyal, Beşerî ve İdari Bilimler',
        'dr' => ['makale_adet' => [$ABCD, 'MAKALE-ABCD', 2], 'bildiri_adet' => 1, 'toplam' => 20],
        'yen' => ['makale_adet' => [$ABCD, 'MAKALE-ABCD', 2], 'proje' => 'her', 'bildiri' => 4, 'egitim' => 5, 'toplam' => 45],
        'doc' => ['makale_puan' => [$ABC, 'MAKALE-ABC', 10], 'atif' => 10, 'proje' => 'abcd', 'bildiri' => 6, 'egitim' => 5, 'toplam' => 110],
        'prof' => ['prof_q' => [$SCI123, 'MAKALE-Q123', 2], 'prof_alt' => [$ABC, 'MAKALE-ABC', 10], 'prof_alt2' => [$HAKEMLI, 'MAKALE', 45], 'atif' => 10, 'proje' => 'yd', 'bildiri' => 8, 'egitim' => 5, 'toplam' => 120],
    ],
];

/**
 * Bir kadronun tablo satırlarını şart düğümlerine çevirir.
 *
 * @param  array<string, mixed>  $s
 * @param  array<string, string|int>|null  $donem
 * @return list<array<string, mixed>>
 */
$satirlar = function (array $s, ?array $donem, string $onek): array {
    $c = [];

    if (isset($s['makale_adet'])) {
        $m = $s['makale_adet'];
        $c[] = Kalip::adet(
            $onek.((string) $m[0]).' en az '.((int) $m[2]).' makale yayımlamış olmak',
            [(string) $m[1]], (int) $m[2], donem: $donem, madde: 'Makale',
        );
    }

    if (isset($s['makale_baslica'])) {
        $m = $s['makale_baslica'];
        $c[] = Kalip::adet(
            $onek.((string) $m[0]).' başlıca yazar olarak en az '.((int) $m[2])
            .' makale yayımlamış olmak',
            [(string) $m[1]], (int) $m[2], 'baslica', $donem, madde: 'Makale',
        );
    }

    foreach (['makale_puan', 'makale_puan2'] as $anahtar) {
        if (isset($s[$anahtar])) {
            $m = $s[$anahtar];
            $c[] = Kalip::puanDan(
                $onek.((string) $m[0]).' yayımlanmış makalelerden en az '.((int) $m[2])
                .' puan almış olmak',
                [(string) $m[1]], (int) $m[2], $donem, madde: 'Makale',
            );
        }
    }

    if (isset($s['prof_q'])) {
        $q = $s['prof_q'];
        $a = $s['prof_alt'];
        $altKosullar = [Kalip::puanDan(
            $onek.((string) $a[0]).' yayımlanmış makalelerden en az '.((int) $a[2])
            .' puan almış olmak',
            [(string) $a[1]], (int) $a[2], $donem, madde: 'Makale',
        )];

        if (isset($s['prof_alt2'])) {
            $a2 = $s['prof_alt2'];
            $altKosullar[] = Kalip::puanDan(
                $onek.((string) $a2[0]).' yayımlanmış makalelerden toplam en az '.((int) $a2[2])
                .' puan almış olmak',
                [(string) $a2[1]], (int) $a2[2], $donem, madde: 'Makale',
            );
        }

        $c[] = Kalip::veya('Makale koşullarından biri', [
            Kalip::adet(
                $onek.((string) $q[0]).' en az '.((int) $q[2]).' makale yayımlamış olmak',
                [(string) $q[1]], (int) $q[2], donem: $donem, madde: 'Makale',
            ),
            count($altKosullar) === 1
                ? $altKosullar[0]
                : Kalip::ve('Makale puanı koşulu', $altKosullar),
        ]);
    }

    if (isset($s['kitap'])) {
        $k = $s['kitap'];
        $c[] = Kalip::puanDan(
            $onek.((string) $k[0]).' en az '.((int) $k[2]).' puan almış olmak',
            [(string) $k[1]], (int) $k[2], $donem, madde: 'Kitap',
        );
    }

    if (isset($s['atif'])) {
        $c[] = Kalip::puanDan(
            $onek.'aldığınız atıflardan en az '.((int) $s['atif']).' puan almış olmak',
            ['ATIF'], (int) $s['atif'], $donem, madde: 'Atıf',
        );
    }

    if (isset($s['proje'])) {
        $c[] = match ((string) $s['proje']) {
            'her' => Kalip::adet(
                $onek.'başarı ile tamamlanmış en az bir bilimsel araştırma projesinde görev almak',
                ['PROJE'], 1, donem: $donem, madde: 'Proje',
            ),
            'yd' => Kalip::veya('Proje koşullarından biri', [
                Kalip::adet(
                    $onek.'başarı ile tamamlanmış en az bir bilimsel araştırma projesinde '
                    .'yürütücü ya da danışman olmak',
                    ['PROJE-ABCD-YD'], 1, donem: $donem, madde: 'Proje',
                ),
                Kalip::adet(
                    $onek.'en az iki öğrenci projesi veya yarışmasında eğitmen, danışman ya da '
                    .'yürütücü olarak görev almak',
                    ['PROJE-E'], 2, donem: $donem, madde: 'Proje',
                ),
            ]),
            default => Kalip::veya('Proje koşullarından biri', [
                Kalip::adet(
                    $onek.'başarı ile tamamlanmış en az bir bilimsel araştırma projesinde görev almak',
                    ['PROJE-ABCD'], 1, donem: $donem, madde: 'Proje',
                ),
                Kalip::adet(
                    $onek.'en az iki öğrenci projesi veya yarışmasında eğitmen, danışman ya da '
                    .'yürütücü olarak görev almak',
                    ['PROJE-E'], 2, donem: $donem, madde: 'Proje',
                ),
            ]),
        };
    }

    if (isset($s['bildiri_adet'])) {
        $c[] = Kalip::adet(
            $onek.'bilimsel toplantılarda en az '.((int) $s['bildiri_adet']).' çalışma sunmuş olmak',
            ['BILDIRI'], (int) $s['bildiri_adet'], donem: $donem, madde: 'Bilimsel Toplantı',
        );
    }

    if (isset($s['bildiri'])) {
        $c[] = Kalip::puanDan(
            $onek.'bilimsel toplantılarda sunulan çalışmalardan en az '.((int) $s['bildiri'])
            .' puan almış olmak',
            ['BILDIRI'], (int) $s['bildiri'], $donem, madde: 'Bilimsel Toplantı',
        );
    }

    if (isset($s['egitim'])) {
        $c[] = Kalip::puanDan(
            $onek.'eğitim-öğretim faaliyetlerinden en az '.((int) $s['egitim']).' puan almış olmak',
            ['EGITIM'], (int) $s['egitim'], $donem, madde: 'Eğitim-Öğretim',
        );
    }

    if (isset($s['tasarim'])) {
        $c[] = Kalip::puanDan(
            $onek.'tasarım, planlama, koruma projesi, yarışma ve yazılım faaliyetlerinden en az '
            .((int) $s['tasarim']).' puan almış olmak',
            ['TASARIM'], (int) $s['tasarim'], $donem, madde: 'Tasarım/Yarışma/Yazılım',
        );
    }

    $c[] = Kalip::toplam((int) $s['toplam'], $donem);

    return $c;
};

/** Doçent ve profesörlükte yabancı dil şartı bir makaleyle karşılanabiliyor. */
$dilKosulu = Kalip::veya('Yabancı dil koşulu ya da muafiyeti', [
    Kalip::yds(60),
    Kalip::adet(
        'SCIE, SSCI, AHCI ya da Scopus kapsamındaki bir dergide en az bir makale yayımlamış olmak',
        ['MAKALE-ABC'], 1, madde: '8-2',
    ),
]);

$esikler = [];

foreach ($ALANLAR as $alan => $tanim) {
    $ad = (string) $tanim['ad'];
    $cetvel = "sinop-2025-{$alan}";
    $dr = $tanim['dr'];
    $yen = $tanim['yen'];
    $doc = $tanim['doc'];
    $prof = $tanim['prof'];

    $esikler[] = [
        'anahtar' => "sinop-{$alan}-dr",
        'aday_notu' => "{$ad} temel alanında doktor öğretim üyesi kadrosuna İLK ATANMA koşulları. "
            .'Doktora, tıpta/diş hekimliğinde/eczacılıkta/veteriner hekimlikte uzmanlık ya da '
            .'sanatta yeterlik derecesi ve merkezi yabancı dil sınavından en az 60 puan '
            .'gerekiyor.'.$NOT_DIL.$NOT_MUAFIYET.$NOT_TAVAN,
        'universite' => $UNIVERSITE,
        'kadro' => 'dr_ogr_uyesi',
        'alan' => [$alan],
        'cetvel' => $cetvel,
        'notlar' => "Tablo ({$ad}) Dr. Öğr. Üyesi İlk Atama sütunu; asgari toplam "
            .((int) $dr['toplam']).' puan.',
        'sart' => Kalip::ve("Doktor Öğretim Üyesi kadrosuna ilk atanma — {$ad}", [
            Kalip::beyan(
                'Doktora, tıpta/diş hekimliğinde/eczacılıkta/veteriner hekimlikte uzmanlık ya da '
                .'sanatta yeterlik derecesi almış olmak',
                '5',
            ),
            Kalip::yds(60),
            ...$satirlar($dr, null, ''),
        ]),
    ];

    $esikler[] = [
        'anahtar' => "sinop-{$alan}-dr-yeniden",
        'aday_notu' => "{$ad} temel alanında doktor öğretim üyesi kadrosuna YENİDEN ATANMA "
            .'koşulları. Yalnız son atanma tarihinizden sonraki faaliyetleriniz sayılıyor ve '
            .'yeniden atanmada yabancı dil şartı aranmıyor. Yönergenin yürürlüğe girdiği '
            .'01.10.2025 tarihinde yeniden atanma tarihinize bir yıldan az kalmışsa toplam puanın '
            .'1/3\'ü, iki yıldan az kalmışsa 2/3\'ü isteniyor; burada TAM puan gösteriliyor.'
            .$NOT_MUAFIYET.$NOT_TAVAN,
        'universite' => $UNIVERSITE,
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'alan' => [$alan],
        'cetvel' => $cetvel,
        'notlar' => "Tablo ({$ad}) Dr. Öğr. Üyesi Yeniden Atama sütunu; asgari toplam "
            .((int) $yen['toplam']).' puan. Geçici Madde 1 indirimi uygulanmadı.',
        'sart' => Kalip::ve("Doktor Öğretim Üyesi kadrosuna yeniden atanma — {$ad}",
            $satirlar($yen, $SON_ATAMA, 'Son atanma tarihinizden sonra ')),
    ];

    $esikler[] = [
        'anahtar' => "sinop-{$alan}-docentlik",
        'aday_notu' => "{$ad} temel alanında doçent kadrosuna atanma koşulları. Puan ve sayı "
            .'koşullarının tamamı DOKTORA unvanınızı aldıktan sonraki faaliyetlerden sağlanmalı. '
            .'Yabancı dil sınavından en az 60 puan gerekiyor; SCIE, SSCI, AHCI ya da Scopus '
            .'kapsamındaki bir dergide en az bir makaleniz varsa bu şart aranmıyor.'
            .$NOT_DIL.$NOT_MUAFIYET.$NOT_TAVAN,
        'universite' => $UNIVERSITE,
        'kadro' => 'docentlik',
        'alan' => [$alan],
        'cetvel' => $cetvel,
        'notlar' => "Tablo ({$ad}) Doçent Atama sütunu; asgari toplam "
            .((int) $doc['toplam']).' puan.',
        'sart' => Kalip::ve("Doçent kadrosuna atanma — {$ad}", [
            Kalip::beyan('Üniversitelerarası Kurul kararıyla doçent unvanını almış olmak', '5'),
            $dilKosulu,
            ...$satirlar($doc, $DOKTORA, 'Doktora unvanınızı aldıktan sonra '),
        ]),
    ];

    $esikler[] = [
        'anahtar' => "sinop-{$alan}-profesorluk",
        'aday_notu' => "{$ad} temel alanında profesör kadrosuna atanma koşulları. Puan ve sayı "
            .'koşullarının tamamı DOÇENT unvanınızı aldıktan sonraki faaliyetlerden sağlanmalı. '
            .'Bunlara ek olarak kadronun ilan edildiği tarihte yürürlükte olan ÜAK doçentlik '
            .'başvuru şartlarını (lisansüstü tez çalışmasından yayın ve ulusal makale şartı '
            .'hariç) bir kez daha sağlamış olmanız gerekiyor; bu koşul ÜAK\'ın kendi cetveline '
            .'bağlı olduğu için motor hesaplayamıyor. Yabancı dil sınavından en az 60 puan '
            .'gerekiyor; SCIE, SSCI, AHCI ya da Scopus kapsamındaki bir dergide en az bir '
            .'makaleniz varsa bu şart aranmıyor.'.$NOT_DIL.$NOT_MUAFIYET.$NOT_TAVAN,
        'universite' => $UNIVERSITE,
        'kadro' => 'profesorluk',
        'alan' => [$alan],
        'cetvel' => $cetvel,
        'notlar' => "Tablo ({$ad}) Profesör Atama sütunu; asgari toplam "
            .((int) $prof['toplam']).' puan. Madde 8(4) ÜAK şartı hesaplanamıyor.',
        'sart' => Kalip::ve("Profesör kadrosuna atanma — {$ad}", [
            $dilKosulu,
            Kalip::hesaplanamiyor(
                'Kadronun ilan edildiği tarih itibarıyla yürürlükteki ÜAK doçentlik temel alan '
                .'başvuru şartlarını (lisansüstü tez çalışmasından yayın ve ulusal makale şartı '
                .'hariç) bir kez daha sağlamış olmak',
                '8-4',
            ),
            ...$satirlar($prof, $DOCENTLIK, 'Doçent unvanınızı aldıktan sonra '),
        ]),
    ];
}

return $esikler;
