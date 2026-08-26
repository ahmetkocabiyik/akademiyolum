<?php

/**
 * İSTANBUL NİŞANTAŞI ÜNİVERSİTESİ — Öğretim Üyesi Atama ve Yükseltme Ölçütleri
 * Yönergesi (Senato Kararları 2025/16)
 * Kaynak: pdf/17537100182.istanbulnisantasiuniversitesi.pdf
 *
 * TEK PUAN TABLOSU, TEMEL ALAN AYRIMI YOK. Yönerge on üç maddede yalnızca üç
 * kadroyu düzenliyor ve her kadroda İKİ SAYI istiyor: EK 1-A (Bilimsel
 * Yayınlar) bölümünden asgari puan, üstüne tablonun tamamından toplam puan.
 * Alan başına ayrı tablo, ayrı baraj ya da yayın sayısı koşulu yok.
 *
 *   Dr. Öğr. Üyesi ilk atama   A'dan  40 · toplam  60
 *   Dr. Öğr. Üyesi yeniden     A'dan  30 · toplam  40
 *   Doçent                     A'dan 120 · toplam 160   (ÜAK unvanı şart)
 *   Profesör                   A'dan 140 (40'ı doçentlik sonrası) · toplam 200
 *
 * ── AYRIM ALANDA DEĞİL FAKÜLTEDE ──
 * Madde 5 ve 6, "Tıp Fakültesi, Diş Hekimliği Fakültesi ve Mühendislik
 * Mimarlık Fakültesi" için barajı yükseltiyor: doçentlikte 140/180,
 * profesörlükte 200/300 (80'i doçentlik sonrası). Dr. Öğr. Üyeliğinde böyle
 * bir ayrım YOK — Madde 4 tek paragraf.
 *
 * Eşleştirme:
 *   Mühendislik ve Mimarlık temel alanları → yüksek baraj (Mühendislik
 *       Mimarlık Fakültesi tek bir fakülte).
 *   Sağlık Bilimleri → İKİ EŞİK. Tıp ve Diş Hekimliği yüksek barajda, öteki
 *       sağlık birimleri (eczacılık, hemşirelik, sağlık bilimleri) genel
 *       barajda. Aynı (kadro, alan) çiftinde iki eşik doğduğu için ayrım
 *       yalnızca `birim` ile kurulabiliyor; Karabük'teki tıp fakültesi
 *       istisnasının aynısı.
 *   Kalan dokuz alan → genel baraj.
 *
 * MİMARLIK BİRİM AYRIMI YAPILMADI: yönerge tek bir "Mühendislik Mimarlık
 * Fakültesi" tanıyor, mimarlık ve tasarım programlarının başka bir fakültede
 * olup olmadığı belgeden anlaşılmıyor. Belirsizlik adayın puanını fazla
 * göstermeyecek yönde çözüldü — mimarlık alanına yüksek baraj yazıldı ve aday
 * notunda başka bir birimdeyse teyit etmesi istendi. `birim` ile ikiye bölmek
 * ise birimini seçmeyen mimarlık adayına üniversiteyi hiç göstermezdi.
 *
 * ── SANAT, MÜZİK VE SPOR ALTERNATİFİ ──
 * Madde 4, 5/b ve 6/c aynı cümleyi tekrarlıyor: "Çalışmalarını sanat, müzik ve
 * spor alanında sürdüren ve ilgili Fakültelere başvuran adaylar Ek1-C, D, E'de
 * yer alan faaliyetlerden asgari koşulu tamamlayabilirler." Yani A bölümünün
 * asgari puanı, sanat/müzik/spor bölümlerinden de karşılanabiliyor; TOPLAM
 * puan barajı değişmiyor. Güzel Sanatlar ve Spor Bilimleri alanlarında bu
 * alternatif bir `veya` dalı olarak girildi.
 *
 * İKİ DALIN AYRI AYRI SAĞLANMASI İSTENDİ, karıştırılması değil: profesörlükte
 * hem 140 hem de "40'ı doçentlik sonrası" koşulu var; birini A'dan, ötekini
 * sanat bölümlerinden toplamaya izin vermek yönergenin demediği bir kolaylık
 * olurdu.
 *
 * SPOR ALANINDA ALTERNATİF FİİLEN KAPALI: Ek1-D'nin on altı sportif performans
 * satırının hiçbiri kaynak sözlüğünde karşılık bulmuyor (cetvel dosyasına bak),
 * bu yüzden `veya` dalının küme adı 'C-E' — yalnızca sanat ve müzik. Spor
 * Bilimleri adayının koşulu OLDUĞUNDAN ZOR görünür; aday notunda söylendi.
 *
 * ── YENİDEN ATANMA "SON ATAMA SONRASI" OKUNDU ──
 * Madde 4'ün ikinci fıkrası "üç yılda bir yeniden atama yapılır… yeniden
 * atanma için Ek 1-A'dan asgari 30, toplamda 40 puan" diyor ama puanların
 * hangi dönemden toplanacağını YAZMIYOR. Kariyerin tamamından okunursa baraj
 * ilk atamanınkinden (40/60) düşük kalır ve göreve başlamış herkes onu zaten
 * sağlamış olur — fıkra anlamsızlaşır. Bu yüzden son atama tarihinden sonrası
 * olarak girildi; iki okumadan adayı daha hazır göstermeyeni bu.
 *
 * ── PROFESÖRLÜĞÜN İKİ EK KAPISI ──
 * Madde 6/a lisansüstü tez yürütücülüğü istiyor ve "ilgili alanda lisansüstü
 * program olmayan adaylar muafiyet talep edebilir" diyor. Muafiyet jüri ve
 * yönetim kararı olduğu için koşul olduğu gibi yazıldı; muaf olabilecek aday
 * koşulu sağlanmamış görecek, aday notunda anlatıldı.
 *
 * Madde 6/b "Ek1'de (1a-2a-3a-5a) belirtilen eserlerden birinci isim olduğu
 * biri başlıca araştırma eseri olarak sunulmalıdır" diyor. Kümenin 2a'sı
 * (yurt dışı yayınevi kitabı) cetvelde 3a ile birleşti — kaynak kaydı iki
 * yayınevini ayırmıyor — bu yüzden küme 1a, 3a ve 5a'dan ibaret; adayın
 * ulaşabileceği kalemler aynı.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   Madde 7 (tıp ve diş hekimliğinde öğretim üyesi eksiği olan anabilim
 *       dallarında puan koşullarının aranmaması) bir muafiyet yolu; adayın
 *       sağlayacağı bir koşul değil, kadro ilanına bağlı.
 *   Madde 8'in "eğitime katkı, idari görevler, değişim programları, ödüller,
 *       topluma ve sanayiye dönük etkinlikler de dikkate alınır" hükmü
 *       değerlendirme ölçütü; puan tablosunda karşılığı yok.
 *   Yabancı dil şartı yönergede geçmiyor; uydurulmadı.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/nisantasi-2025.php
 */

use App\Services\Scoring\Sart\Kalip;

$DOC = Kalip::DOCENTLIK_SONRASI;
$SON_ATAMA = Kalip::SON_ATAMA_SONRASI;

/** Yönergenin fakülte ayrımına girmeyen, genel barajdaki alanlar. */
$genelAlanlar = ['fen', 'sosyal', 'egitim', 'ilahiyat', 'hukuk', 'filoloji', 'ziraat'];

/** "Sanat, müzik ve spor alanında sürdürenler" alternatifinin geçerli olduğu alanlar. */
$sanatAlanlari = ['guzel_sanatlar', 'spor'];

/** Mühendislik Mimarlık Fakültesi — yüksek baraj. */
$muhMimAlanlari = ['muhendislik', 'mimarlik'];

$tipDis = 'Tıp Fakültesi ve Diş Hekimliği Fakültesi';
$digerSaglik = 'Tıp ve Diş Hekimliği dışındaki sağlık birimleri';
$muhMim = 'Mühendislik Mimarlık Fakültesi';

$sporNotu = 'Sportif performans kalemleri (antrenörlük, hakemlik, milli takım ve federasyon '
    .'görevleri) faaliyet kaydında karşılık bulmadığı için puanlanamıyor; yönergenin '
    .'"spor alanında çalışanlar asgari puanı Ek1-D\'den tamamlayabilir" alternatifi bu yüzden '
    .'yalnızca sanat ve müzik kalemleriyle çalışıyor. Spor Bilimleri adayıysanız koşul '
    .'olduğundan zor görünür.';

$mimarlikNotu = 'Yönerge yüksek barajı "Tıp, Diş Hekimliği ve Mühendislik Mimarlık '
    .'Fakültesi"ne bağlıyor. Mimarlık ya da tasarım programınız başka bir fakültedeyse '
    .'genel baraj (doçentlikte 120/160, profesörlükte 140/200) geçerli olabilir; '
    .'başvurmadan önce üniversiteye teyit ettirin.';

/**
 * "Ek 1-A'da yer alan yayın ve faaliyetlerden asgari N puan" kapısı.
 *
 * Sanat, müzik ve spor alanlarında aynı puan Ek1-C ve E'den de toplanabiliyor;
 * o alanlarda kapı iki dallı bir `veya` olur.
 *
 * @param  array<string, mixed>|null  $donem
 * @return array<string, mixed>
 */
$asgariPuan = function (int $puan, bool $sanat, string $madde, ?array $donem = null): array {
    // `puanDan` dönemi metne kendisi eklemiyor (yalnızca `toplam` ekliyor);
    // yazılmazsa aday yeniden atanma satırında ilk atamanınkiyle aynı cümleyi
    // görüp neden 30 puanının sayılmadığını anlayamıyor.
    $ek = $donem === null ? '' : ' son atamanızdan sonra';

    $yayindan = Kalip::puanDan(
        "Kitap, makale ve ansiklopedi maddelerinizden{$ek} en az {$puan} puan",
        ['A'], $puan, $donem, madde: $madde,
    );

    if (! $sanat) {
        return $yayindan;
    }

    return Kalip::veya("Bilimsel yayınlardan ya da sanat ve müzik çalışmalarından{$ek} en az {$puan} puan", [
        $yayindan,
        Kalip::puanDan(
            "Sanat, tasarım, müzik ve sahne performansı kalemlerinizden{$ek} en az {$puan} puan",
            ['C-E'], $puan, $donem, madde: $madde,
        ),
    ]);
};

/**
 * Profesörlükte iki kapı birden var: kariyerin tamamından asgari puan ve onun
 * içinden doçentlik sonrasına düşen pay. Sanat alanlarında iki kapının İKİSİ
 * DE aynı daldan sağlanmalı; yönerge dalları karıştırmaya izin vermiyor.
 *
 * @return array<string, mixed>
 */
$profesorAsgari = function (int $puan, int $docentlikSonrasi, bool $sanat, string $madde) use ($DOC): array {
    /** @return array<string, mixed> */
    $dal = function (string $etiket, string $grup) use ($puan, $docentlikSonrasi, $madde, $DOC): array {
        return Kalip::ve(
            "{$etiket} en az {$puan} puan, bunun en az {$docentlikSonrasi} puanı doçentlik unvanınızdan sonra",
            [
                Kalip::puanDan("{$etiket} en az {$puan} puan", [$grup], $puan, madde: $madde),
                Kalip::puanDan("{$etiket} doçentlik unvanınızdan sonra en az {$docentlikSonrasi} puan", [$grup], $docentlikSonrasi, $DOC, madde: $madde),
            ],
        );
    };

    $yayin = $dal('Kitap, makale ve ansiklopedi maddelerinizden', 'A');

    if (! $sanat) {
        return $yayin;
    }

    return Kalip::veya("Bilimsel yayınlardan ya da sanat ve müzik çalışmalarından en az {$puan} puan", [
        $yayin,
        $dal('Sanat, tasarım, müzik ve sahne performansı kalemlerinizden', 'C-E'),
    ]);
};

/**
 * @param  list<string>  $alanlar
 * @return array<string, mixed>
 */
$dr = function (string $anahtar, array $alanlar, bool $sanat, ?string $birim, string $ekNot) use ($asgariPuan): array {
    return [
        'anahtar' => "nisantasi-dr-{$anahtar}",
        'aday_notu' => 'İki kapı var: bilimsel yayın kalemlerinizden 40 puan ve tablonun '
            .'tamamından toplam 60 puan. Tek bir SCI-Expanded, SSCI ya da AHCI makalesi '
            .'(40 puan) birinci kapıyı tek başına açıyor. Yönergede idari görev, verilen ders '
            .'ve toplumsal katkı için puan satırı yok; bu faaliyetleriniz toplama girmez. '
            .$ekNot,
        'universite' => 'Nişantaşı Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $alanlar,
        'birim' => $birim,
        'cetvel' => 'nisantasi-2025',
        'notlar' => 'Madde 4/1: "Ek 1-A\'da yer alan yayın ve faaliyetlerden asgari 40 puana '
            .'sahip olma koşuluyla toplamda tüm maddelerde 60 puanı tamamlanmış olmak gerekir." '
            .'Dr. Öğr. Üyeliğinde fakülte ayrımı yok; Madde 4 tek paragraf.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi kadrosuna ilk atanma', [
            $asgariPuan(40, $sanat, 'Madde 4/1'),
            Kalip::toplam(60),
        ]),
    ];
};

/**
 * @param  list<string>  $alanlar
 * @return array<string, mixed>
 */
$drYeniden = function (string $anahtar, array $alanlar, bool $sanat, ?string $birim, string $ekNot) use ($asgariPuan, $SON_ATAMA): array {
    return [
        'anahtar' => "nisantasi-dr-yeniden-{$anahtar}",
        'aday_notu' => 'Yeniden atama üç yılda bir yapılıyor. Yönerge 30 ve 40 puanın hangi '
            .'dönemden toplanacağını yazmıyor; kariyerin tamamından okunsaydı baraj ilk '
            .'atamanınkinden düşük kalacağı için son atama tarihinizden sonrası olarak '
            .'girildi. Son atama tarihinizi profilinize girmezseniz bu eşik hesaplanamaz. '
            .$ekNot,
        'universite' => 'Nişantaşı Üniversitesi',
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'alan' => $alanlar,
        'birim' => $birim,
        'cetvel' => 'nisantasi-2025',
        'notlar' => 'Madde 4/2: "Yeniden atanma için Ek 1-A\'da yer alan yayın ve '
            .'faaliyetlerden asgari 30 puana sahip olma koşuluyla toplamda tüm maddelerde 40 '
            .'puanı tamamlanmış olmak gerekir." Dönem yönergede belirtilmemiş; son atama '
            .'sonrası okundu (gerekçe dosya başlığında).',
        'sart' => Kalip::ve('Dr. Öğr. Üyeliğine yeniden atanma', [
            $asgariPuan(30, $sanat, 'Madde 4/2', $SON_ATAMA),
            Kalip::toplam(40, $SON_ATAMA),
        ]),
    ];
};

/**
 * @param  list<string>  $alanlar
 * @return array<string, mixed>
 */
$docent = function (string $anahtar, array $alanlar, bool $sanat, ?string $birim, int $asgari, int $toplam, string $madde, string $ekNot) use ($asgariPuan): array {
    return [
        'anahtar' => "nisantasi-docent-{$anahtar}",
        'aday_notu' => 'Üç kapı var: ÜAK doçentlik unvanı, bilimsel yayın kalemlerinizden '
            ."{$asgari} puan ve tablonun tamamından toplam {$toplam} puan. Yönerge dönem "
            .'kısıtı koymuyor; doktoradan önceki çalışmalarınız da sayılıyor. Yönergede idari '
            .'görev, verilen ders ve toplumsal katkı için puan satırı yok. '.$ekNot,
        'universite' => 'Nişantaşı Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $alanlar,
        'birim' => $birim,
        'cetvel' => 'nisantasi-2025',
        'notlar' => "{$madde}: Ek 1-A'dan asgari {$asgari} puan, tüm maddelerden toplam "
            ."{$toplam} puan. Madde 5/a ayrıca ÜAK doçentlik unvanını şart koşuyor.",
        'sart' => Kalip::ve('Doçent kadrosuna yükseltilip atanma', [
            Kalip::beyan('Üniversitelerarası Kurul Başkanlığınca doçent unvanını almış olmak', 'Madde 5/a'),
            $asgariPuan($asgari, $sanat, $madde),
            Kalip::toplam($toplam),
        ]),
    ];
};

/**
 * @param  list<string>  $alanlar
 * @return array<string, mixed>
 */
$profesor = function (string $anahtar, array $alanlar, bool $sanat, ?string $birim, int $asgari, int $docentlikSonrasi, int $toplam, string $madde, string $ekNot) use ($profesorAsgari, $DOC): array {
    return [
        'anahtar' => "nisantasi-profesor-{$anahtar}",
        'aday_notu' => 'Dört kapı var: en az bir lisansüstü tez yürütücülüğü, doçentliğinizden '
            .'sonra birinci isim olduğunuz bir başlıca araştırma eseri, bilimsel yayın '
            ."kalemlerinizden {$asgari} puan (bunun {$docentlikSonrasi} puanı doçentlik "
            ."sonrasında) ve tablonun tamamından toplam {$toplam} puan. Alanınızda lisansüstü "
            .'program yoksa tez yürütücülüğünden muafiyet talep edebilirsiniz (Madde 6/a); '
            .'muafiyet burada hesaplanamadığı için koşul sağlanmamış görünür. '.$ekNot,
        'universite' => 'Nişantaşı Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $alanlar,
        'birim' => $birim,
        'cetvel' => 'nisantasi-2025',
        'notlar' => "{$madde}: Ek 1-A'dan asgari {$asgari} puan ({$docentlikSonrasi} puanı "
            ."doçentlik sonrası), tüm maddelerden toplam {$toplam} puan. Madde 6/a lisansüstü "
            .'tez yürütücülüğü, Madde 6/b doçentlik sonrası birinci isim olunan bir başlıca '
            .'araştırma eseri istiyor (kaynaktaki küme "1a-2a-3a-5a").',
        'sart' => Kalip::ve('Profesör kadrosuna yükseltilip atanma', [
            Kalip::adet('Tamamlanmış en az bir lisansüstü tez yürütücülüğü', ['TEZ'], 1, madde: 'Madde 6/a'),
            Kalip::adet(
                'Doçentliğinizden sonra birinci isim olduğunuz ve başlıca araştırma eseri '
                .'olarak sunacağınız bir kitap ya da SCI-Expanded, SSCI veya AHCI makalesi',
                ['BASLICA-ESER'], 1, 'ilk', $DOC, madde: 'Madde 6/b',
            ),
            $profesorAsgari($asgari, $docentlikSonrasi, $sanat, $madde),
            Kalip::toplam($toplam),
        ]),
    ];
};

return [
    // ── Dr. Öğr. Üyesi — fakülte ayrımı yok, tek eşik ──
    $dr('genel', [...$genelAlanlar, ...$muhMimAlanlari, 'saglik'], false, null, ''),
    $dr('sanat', $sanatAlanlari, true, null, $sporNotu),

    $drYeniden('genel', [...$genelAlanlar, ...$muhMimAlanlari, 'saglik'], false, null, ''),
    $drYeniden('sanat', $sanatAlanlari, true, null, $sporNotu),

    // ── Doçent ──
    $docent('genel', $genelAlanlar, false, null, 120, 160, 'Madde 5/b', ''),
    $docent('sanat', $sanatAlanlari, true, null, 120, 160, 'Madde 5/b', $sporNotu),
    $docent('saglik', ['saglik'], false, $digerSaglik, 120, 160, 'Madde 5/b', ''),
    $docent('tip-dis', ['saglik'], false, $tipDis, 140, 180, 'Madde 5/c', ''),
    $docent('muh-mim', $muhMimAlanlari, false, $muhMim, 140, 180, 'Madde 5/c', $mimarlikNotu),

    // ── Profesör ──
    $profesor('genel', $genelAlanlar, false, null, 140, 40, 200, 'Madde 6/c', ''),
    $profesor('sanat', $sanatAlanlari, true, null, 140, 40, 200, 'Madde 6/c', $sporNotu),
    $profesor('saglik', ['saglik'], false, $digerSaglik, 140, 40, 200, 'Madde 6/c', ''),
    $profesor('tip-dis', ['saglik'], false, $tipDis, 200, 80, 300, 'Madde 6/d', ''),
    $profesor('muh-mim', $muhMimAlanlari, false, $muhMim, 200, 80, 300, 'Madde 6/d', $mimarlikNotu),
];
