<?php

use App\Services\Scoring\Sart\Kalip;

/**
 * FATİH SULTAN MEHMET VAKIF ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme
 * ve Atanma Yönergesi (YÖK Genel Kurulu onayı 24.10.2024)
 * Kaynak: pdf/17634002431.Fatih Sultan Mehmet Vakıf Üniversitesi Kriter.pdf
 *
 * Cetvel: cetvel/fsmvu-2024.php
 *
 * ── EŞİKLER FAKÜLTEYE GÖRE, TEMEL ALANA GÖRE DEĞİL ──
 * MADDE 5'in Tablo 1'i asgari puanları temel alana değil FAKÜLTEYE bağlıyor
 * (Eğitim, Hukuk, İİBF, İnsan ve Toplum Bilimleri, İslami İlimler, Meslek
 * Yüksekokulları, Mühendislik, Sanat-Tasarım-Mimarlık). Bu yüzden her kayıt
 * `birim` taşıyor ve aday fakültesini seçmeden eşik bulunamıyor. Aynı temel
 * alana birden çok fakülte düştüğü için (sosyal bilimler hem İİBF'de hem
 * İnsan ve Toplum Bilimleri Fakültesinde) ayrım zorunlu.
 *
 * Tabloda her kadro için İKİ baraj var: "A1, A2 ve A5" sütunu (uluslararası
 * yayınlar, ulusal yayınlar ve sanatsal faaliyetler) ile "Toplam" sütunu
 * (tablonun tamamı).
 *
 * ── YORUM KARARLARI (§0) ──
 *   Meslek Yüksekokulu satırı on iki temel alanın tamamına açıldı: satır
 *       fakülteye göre yazıldığı için MYO adayının hangi temel alandan
 *       geldiğine bakılmıyor. Sağlık, spor ve ziraat temel alanları
 *       üniversitenin fakülte listesinde geçmediğinden bu alanlarda yalnızca
 *       Meslek Yüksekokulu eşiği var.
 *   MADDE 6/2-a "doktora eğitimine BAŞLADIKTAN sonra" diyor; araçta
 *       "doktora sonrası" dönemi doktora unvanının alındığı tarihten
 *       başladığı için bu koşula dönem konulmadı. Doktoranıza başlamadan
 *       önce yayımladığınız makale de sayılıyor; yönergeye göre sayılmamalı.
 *   MADDE 17/8'in "son beş yıl içinde ilgili birimde lisansüstü program
 *       olmadığının belgelenmesi hâlinde tez koşulu aranmaz" muafiyeti
 *       yazılmadı; koşulu gevşeten bir yol olduğu için §0 gereği atlandı.
 *   Tablo 1'in yıldız dipnotu (İİBF ve Mühendislik Fakültesinde doçent ve
 *       profesör kadroları için "çalışmalardan en az birinin
 *       SSCI/SCIE/AHCI/ESCI/SCOPUS taranan dergilerde yayımlanmış olması")
 *       ayrı bir adet koşulu olarak eklendi.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   MADDE 4/3'ün yabancı dille eğitim yapan bölümlerde aradığı dil şartı —
 *       bölüme bağlı ve yönerge sayı vermeyip ilgili yönetmeliğe atıf
 *       yapıyor.
 *   MADDE 11'in yeniden atamada aradığı "bölüm başkanı ve birim
 *       yöneticisinin gerekçeli önerisi ile yönetim kurulunun olumlu kararı"
 *       dışında sayısal bir ölçüt yok; yeniden atama eşiği yalnızca bu
 *       beyandan oluşuyor.
 *   MADDE 23'ün jüri raporu içeriğine ilişkin nitel başlıkları.
 */

/**
 * Tablo 1: fakülte başına [A1-A2-A5 barajı, Toplam barajı] üçlüsü.
 *
 * @var list<array{birim: string, anahtar: string, alan: list<string>, dr: array{int, int}, doc: array{int, int}, prof: array{int, int}, indeks: bool}>
 */
$fakulteler = [
    ['birim' => 'Eğitim Fakültesi', 'anahtar' => 'egitim-fak', 'alan' => ['egitim'],
        'dr' => [40, 125], 'doc' => [300, 600], 'prof' => [400, 700], 'indeks' => false],
    ['birim' => 'Hukuk Fakültesi', 'anahtar' => 'hukuk-fak', 'alan' => ['hukuk'],
        'dr' => [40, 125], 'doc' => [300, 600], 'prof' => [400, 700], 'indeks' => false],
    ['birim' => 'İktisadi ve İdari Bilimler Fakültesi', 'anahtar' => 'iibf', 'alan' => ['sosyal'],
        'dr' => [40, 125], 'doc' => [300, 600], 'prof' => [400, 700], 'indeks' => true],
    ['birim' => 'İnsan ve Toplum Bilimleri Fakültesi', 'anahtar' => 'itbf', 'alan' => ['sosyal', 'filoloji'],
        'dr' => [40, 125], 'doc' => [300, 600], 'prof' => [400, 700], 'indeks' => false],
    ['birim' => 'İslami İlimler Fakültesi', 'anahtar' => 'islami-ilimler', 'alan' => ['ilahiyat'],
        'dr' => [40, 125], 'doc' => [300, 600], 'prof' => [400, 700], 'indeks' => false],
    ['birim' => 'Mühendislik Fakültesi', 'anahtar' => 'muhendislik-fak', 'alan' => ['muhendislik', 'fen'],
        'dr' => [40, 125], 'doc' => [400, 600], 'prof' => [500, 700], 'indeks' => true],
    ['birim' => 'Sanat, Tasarım ve Mimarlık Fakültesi', 'anahtar' => 'sanat-fak', 'alan' => ['guzel_sanatlar', 'mimarlik'],
        'dr' => [40, 125], 'doc' => [300, 600], 'prof' => [400, 700], 'indeks' => false],
    ['birim' => 'Meslek Yüksekokulu', 'anahtar' => 'myo',
        'alan' => ['egitim', 'hukuk', 'sosyal', 'filoloji', 'ilahiyat', 'muhendislik', 'fen',
            'guzel_sanatlar', 'mimarlik', 'saglik', 'spor', 'ziraat'],
        'dr' => [30, 100], 'doc' => [200, 400], 'prof' => [300, 600], 'indeks' => false],
];

$INDEKS_KOSULU = 'Çalışmalarınızdan en az birinin SSCI, SCIE, AHCI, ESCI ya da SCOPUS tarafından taranan dergilerde yayımlanmış olması';

/** Adaya gösterilen küme adı; yönergenin "A1, A2 ve A5" sütunu (§2 kod yasağı). */
$YAYIN_ADI = 'Yayın ve sanatsal faaliyet';

$BARAJ_NOTU = 'Yönerge her kadro için iki ayrı baraj koyuyor. Birincisi yalnızca '
    .'YAYINLARINIZDAN ve SANATSAL FAALİYETLERİNİZDEN hesaplanıyor: uluslararası ve ulusal '
    .'makaleler, bildiriler, kitaplar, kitap bölümleri, çeviriler ile sergi, konser ve benzeri '
    .'etkinlikler. İkincisi ise tüm faaliyetlerinizin toplamı; atıf, rapor, editörlük, patent, '
    .'proje, tez danışmanlığı ve ödül puanlarınız buraya giriyor. İkisini birden sağlamanız '
    .'gerekiyor.';

$esikler = [];

foreach ($fakulteler as $f) {
    $ortakAlan = ['universite' => 'Fatih Sultan Mehmet Vakıf Üniversitesi', 'birim' => $f['birim'],
        'alan' => $f['alan'], 'cetvel' => 'fsmvu-2024'];

    // ══ DOKTOR ÖĞRETİM ÜYELİĞİ (MADDE 6) ══
    $esikler[] = array_merge($ortakAlan, [
        'anahtar' => 'fsmvu-'.$f['anahtar'].'-dr',
        'kadro' => 'dr_ogr_uyesi',
        'notlar' => 'MADDE 6/2: ULAKBİM (TR Dizin) ya da hakemli uluslararası bir dergide en az '
            .'1 makale veya özgün bilimsel kitap bölümü; Tablo 1\'e göre A1-A2-A5 sütunundan '
            .$f['dr'][0].', toplamdan '.$f['dr'][1].' puan.',
        'aday_notu' => $f['birim'].' için doktor öğretim üyeliğinde yayın ve sanatsal faaliyet kalemlerinizden '
            .$f['dr'][0].' puan, tüm faaliyetlerinizden '.$f['dr'][1].' puan gerekiyor. Ayrıca '
            .'doktora eğitiminize başladıktan sonra TR Dizin kapsamındaki ya da hakemli '
            .'uluslararası bir dergide en az bir makale (ya da özgün bilimsel kitap bölümü) '
            .'yayımlamış olmanız şart. Araç bu makalenin doktoranıza başlamadan önce yayımlanıp '
            .'yayımlanmadığını ayırt edemiyor. '.$BARAJ_NOTU,
        'sart' => Kalip::ve('Doktor öğretim üyeliği koşulları', [
            Kalip::beyan('Doktor unvanını almış ya da sanat dallarının birinde yeterlik kazanmış olmak', 'MADDE 6/1'),
            Kalip::adet('ULAKBİM tarafından taranan hakemli ulusal bir dergide ya da hakemli uluslararası bir dergide en az 1 makale veya özgün bilimsel kitap bölümü', ['DR-MAKALE'], 1, madde: 'MADDE 6/2-a'),
            Kalip::toplam($f['dr'][0], maddeler: ['A1-A2-A5'], liste: $YAYIN_ADI),
            Kalip::toplam($f['dr'][1], maddeler: ['TOPLAM']),
        ]),
    ]);

    // ══ DOKTOR ÖĞRETİM ÜYELİĞİNE YENİDEN ATAMA (MADDE 11) ══
    $esikler[] = array_merge($ortakAlan, [
        'anahtar' => 'fsmvu-'.$f['anahtar'].'-dr-yeniden',
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'notlar' => 'MADDE 11: yeniden atama için sayısal bir ölçüt yok; bölüm başkanı ve birim '
            .'yöneticisinin gerekçeli önerisi ile ilgili yönetim kurulunun olumlu kararı '
            .'aranıyor.',
        'aday_notu' => 'Fatih Sultan Mehmet Vakıf Üniversitesi yeniden atamada puan barajı '
            .'koymuyor. Yönerge yalnızca bölüm başkanı ile birim yöneticisinin gerekçeli '
            .'önerisini ve ilgili yönetim kurulunun olumlu kararını arıyor; atamalar en az bir, '
            .'en çok dört yıllık yapılıyor ve süre sonunda görev kendiliğinden sona eriyor.',
        'sart' => Kalip::beyan('Bölüm başkanı ve birim yöneticisinin gerekçeli önerisi ile ilgili yönetim kurulunun olumlu kararını almak', 'MADDE 11/1-a'),
    ]);

    // ══ DOÇENTLİK (MADDE 12) ══
    $docCocuklar = [
        Kalip::beyan('Üniversitelerarası Kuruldan doçentlik unvanını ya da doçentlik denklik belgesini almış olmak', 'MADDE 12/1'),
        Kalip::toplam($f['doc'][0], donem: Kalip::DOKTORA_SONRASI, maddeler: ['A1-A2-A5'], liste: $YAYIN_ADI),
        Kalip::toplam($f['doc'][1], donem: Kalip::DOKTORA_SONRASI, maddeler: ['TOPLAM']),
    ];

    if ($f['indeks']) {
        $docCocuklar[] = Kalip::adet($INDEKS_KOSULU, ['INDEKSLI'], 1, donem: Kalip::DOKTORA_SONRASI, madde: 'Tablo 1 dipnotu');
    }

    $esikler[] = array_merge($ortakAlan, [
        'anahtar' => 'fsmvu-'.$f['anahtar'].'-docentlik',
        'kadro' => 'docentlik',
        'notlar' => 'MADDE 12: ÜAK doçentlik unvanı ve doktora unvanını aldıktan sonra Tablo '
            .'1\'e göre A1-A2-A5 sütunundan '.$f['doc'][0].', toplamdan '.$f['doc'][1].' puan.'
            .($f['indeks'] ? ' Tablo 1 dipnotu: çalışmalardan en az biri SSCI/SCIE/AHCI/ESCI/SCOPUS taranan dergide yayımlanmış olmalı.' : ''),
        'aday_notu' => $f['birim'].' için doçent kadrosunda yayın ve sanatsal faaliyet kalemlerinizden '
            .$f['doc'][0].' puan, tüm faaliyetlerinizden '.$f['doc'][1].' puan gerekiyor ve bu '
            .'puanlar DOKTORA unvanını aldıktan sonraki çalışmalardan sayılıyor. '
            .($f['indeks']
                ? 'Bu fakültede ayrıca çalışmalarınızdan en az birinin SSCI, SCIE, AHCI, ESCI ya '
                    .'da SCOPUS taranan bir dergide yayımlanmış olması gerekiyor. '
                : '')
            .'Doçentlik kadrosuna atanmak için sözlü sınav şartı aranmıyor. '.$BARAJ_NOTU,
        'sart' => Kalip::ve('Doçentlik koşulları', $docCocuklar),
    ]);

    // ══ PROFESÖRLÜK (MADDE 17) ══
    $profCocuklar = [
        Kalip::beyan('Doçentlik unvanını aldıktan sonra en az beş yıl, açık bulunan profesörlük kadrosuyla ilgili bilim alanında çalışmış olmak', 'MADDE 17/2'),
        Kalip::beyan('Doçentlikten sonraki asgari çalışma süresinin en az iki yılında bir üniversitede kadrolu olarak ders vermiş olmak', 'MADDE 17/5'),
        Kalip::beyan('Doçent unvanı kazandıktan sonra yayımlanmış bilimsel bir çalışmayı başlıca eser olarak göstermek', 'MADDE 17/7'),
        Kalip::veya('Tez yönetme koşulu', [
            Kalip::adet('En az 3 yüksek lisans tezi yönetmiş olmak', ['TEZ-YL'], 3, madde: 'MADDE 17/8'),
            Kalip::adet('En az 1 doktora tezi yönetmiş olmak', ['TEZ-DOKTORA'], 1, madde: 'MADDE 17/8'),
        ]),
        Kalip::toplam($f['prof'][0], donem: Kalip::DOCENTLIK_SONRASI, maddeler: ['A1-A2-A5'], liste: $YAYIN_ADI),
        Kalip::toplam($f['prof'][1], donem: Kalip::DOCENTLIK_SONRASI, maddeler: ['TOPLAM']),
    ];

    if ($f['indeks']) {
        $profCocuklar[] = Kalip::adet($INDEKS_KOSULU, ['INDEKSLI'], 1, donem: Kalip::DOCENTLIK_SONRASI, madde: 'Tablo 1 dipnotu');
    }

    $esikler[] = array_merge($ortakAlan, [
        'anahtar' => 'fsmvu-'.$f['anahtar'].'-profesorluk',
        'kadro' => 'profesorluk',
        'notlar' => 'MADDE 17: doçentlik sonrası beş yıl, iki yıl kadrolu ders verme, başlıca '
            .'eser, en az 3 yüksek lisans veya 1 doktora tezi yönetimi; Tablo 1\'e göre '
            .'A1-A2-A5 sütunundan '.$f['prof'][0].', toplamdan '.$f['prof'][1].' puan.'
            .($f['indeks'] ? ' Tablo 1 dipnotu ayrıca indeksli dergi koşulu getiriyor.' : ''),
        'aday_notu' => $f['birim'].' için profesörlükte yayın ve sanatsal faaliyet kalemlerinizden '
            .$f['prof'][0].' puan, tüm faaliyetlerinizden '.$f['prof'][1].' puan gerekiyor ve bu '
            .'puanlar DOÇENT unvanını aldıktan sonraki çalışmalardan sayılıyor. '
            .($f['indeks']
                ? 'Bu fakültede ayrıca çalışmalarınızdan en az birinin SSCI, SCIE, AHCI, ESCI ya '
                    .'da SCOPUS taranan bir dergide yayımlanmış olması gerekiyor. '
                : '')
            .'Tez koşulu için en az üç yüksek lisans ya da bir doktora tezi yönetmiş olmalısınız; '
            .'yönerge, son beş yılda ilgili birimde lisansüstü program bulunmadığının '
            .'belgelenmesi hâlinde bu koşulu aramıyor, araç bu muafiyeti uygulamıyor. '.$BARAJ_NOTU,
        'sart' => Kalip::ve('Profesörlük koşulları', $profCocuklar),
    ]);
}

return $esikler;
