<?php

/**
 * İSTANBUL SABAHATTİN ZAİM ÜNİVERSİTESİ — Akademik Yükseltilme ve Atama
 * Kriterleri
 * Kaynak: pdf/17537100932.istanbulsabahattinzaimuniversitesi.pdf
 *
 * BELGEDE TARİH YOK: kabul tarihi, karar numarası ya da yürürlük maddesi
 * geçmiyor. Cetvel dosyasının adındaki 2019, PDF'in oluşturma tarihinden
 * (14/05/2019).
 *
 * ── ÜÇ KATMANLI, İÇ İÇE PUAN BARAJI ──
 * Yönergenin belirleyici özelliği bu: her kadroda barajlar EK-I'in bölüm
 * harfleri üzerinden iç içe geçmiş kümelerle tanımlı ve dıştaki küme içtekini
 * kapsıyor.
 *
 *   Dr. ilk atama   A-J ≥ 100
 *   Dr. yeniden     A-J ≥ 100 · A-U ≥ 150 · toplam ≥ 200  (son dört yıl)
 *   Doçent          A-C ≥ 100 · A-U ≥ 500 · toplam ≥ 600
 *   Profesör        A-C ≥ 200 · A-U ≥ 750 · toplam ≥ 900 veya 1000 (alana göre)
 *
 * Kümelerin karşılığı:
 *   A-C  uluslararası makale, bildiri ve kitap
 *   A-J  bunların üstüne çeviri, atıf, ulusal yayın, ders kitabı ve patent
 *   A-U  bunların üstüne Erasmus, proje, editörlük, hakemlik, ödül, tez, ders
 *        ve bilimsel etkinlikler
 *   toplam  güzel sanatlar uygulamalarını (V) ve idari görevleri (Y) de kapsar
 *
 * TÜRKÇE ALFABE: "A-J" aralığı I ile J arasındaki İ'yi (ulusal atıflar) de
 * kapsıyor; "A-U" ise V ve Y'yi dışarıda bırakıyor. Küme tanımları cetvelin
 * `gruplar` bölümünde tek tek sayıldı.
 *
 * ── ULUSLARARASI KİTAPLAR ALT KAPIYA GİRMİYOR ──
 * Cetvelin C bölümü (uluslararası kitaplar) tamamen boş kaldı: dört satırı da
 * "yurt dışında, uluslararası tanınmış yabancı yayınevince basılmış" koşuluna
 * dayanıyor ve faaliyet kaydı bu ayrımı taşımıyor, hepsi H bölümünün düşük
 * satırlarına düştü (gerekçe cetvel dosyasında). Sonuç: A-C kapısı pratikte
 * yalnızca uluslararası makale ve bildiriden besleniyor. Kapı ulaşılamaz
 * değil — iki SCI makalesi 240 puan eder — ama kitap ağırlıklı alanlarda
 * OLDUĞUNDAN ZOR görünür; aday notunda söylendi.
 *
 * ── YENİDEN ATANMA: SON ATAMA DEĞİL, SON DÖRT YIL ──
 * "Üniversitemizde Doktor Öğretim Üyesi kadrosuna dört yılda bir yeniden
 * atama yapılır. Yeniden atanacaklarda ATANMA ÖNCESİNDEKİ DÖRT YIL İÇİN…"
 * Yönerge dönemi son atama tarihine değil, sabit dört yıllık bir pencereye
 * bağlıyor. `Kalip::sonYil(4)` kullanıldı; böylece eşik son atama tarihini
 * profiline girmemiş adayda da hesaplanıyor (Düzce ve Akdeniz'deki kayan
 * pencerenin aynısı).
 *
 * ── PROFESÖRLÜKTE PUAN BARAJLARINA DÖNEM UYGULANMADI ──
 * Madde şöyle: "Adayların Doçentlik unvanını aldıktan sonra Üniversitelerarası
 * Kurulca belirlenen Doçentlik Başvuru Koşullarına göre ilgili bilim alanı
 * için gerekli olan asgari koşulları sağlaması KOŞULU İLE; a) … en az 900
 * puan almak". "Doçentlik unvanını aldıktan sonra" ibaresi ÜAK koşullarını
 * yeniden sağlama şartına bağlı — noktalı virgülle ayrılan (a)-(e) puan
 * barajlarına değil.
 *
 * Yapı da bu okumayı destekliyor: 100 (Dr.) → 600 (doçent) → 900 (profesör)
 * kariyer boyunca biriken bir merdiven. Barajlar doçentlik sonrasına
 * kısıtlansaydı profesörlük, doçentlikten sonra sıfırdan 900 puan istiyor
 * olurdu; korpusta bu ölçekte bir sıçrama yok.
 *
 * Karşı okuma yine de mümkün; aday notunda üniversiteye teyit ettirmesi
 * istendi. ÜAK koşullarını doçentlik sonrası yeniden sağlama şartı beyan
 * olarak duruyor ve dönemi metninde taşıyor.
 *
 * ── YAZAR PAYLAŞIMI KURALI YOK ──
 * Ölçüt metninde de EK-I'de de çok yazarlı çalışmalarda puanın bölüneceğine
 * dair tek cümle geçmiyor; cetvelde `yazar_katsayisi` bu yüzden tanımlanmadı.
 * Yönerge paylaşımı istediği tek yerde (R.1 ve R.3 ödül satırları) "her bir
 * araştırmacıya" diye açıkça yazıyor, yani sessizlik tercih.
 *
 * ── ALAN KAPSAMI: PROFESÖRLÜK BEŞ TEMEL ALANDA ──
 * Dr. Öğr. Üyeliği ve doçentlikte alan ayrımı yok, on iki temel alanın
 * hepsine yazıldı. Profesörlükte ise yönerge ÜAK temel alan adlarını tek tek
 * sayıyor: Sosyal-Beşeri-İdari, Fen ve Mühendislik, Filoloji, Sağlık, ve
 * "Hukuk, Eğitim Bilimleri ve Öğretmen Yetiştirme".
 *
 * ANILMAYAN ALANLARA PROFESÖRLÜK EŞİĞİ YAZILMADI: İlahiyat, Güzel Sanatlar,
 * Mimarlık, Ziraat ve Spor Bilimleri. Bunları bir gruba katmak adaya
 * yönergede yazmayan bir baraj göstermek olurdu. Güzel Sanatlar'ın durumu
 * özellikle dikkat çekici: EK-I'in V bölümü baştan sona "Güzel Sanatlar Temel
 * Alanında" uygulamalı faaliyetler için yazılmış, ama profesörlük
 * paragrafında o alan sayılmamış.
 *
 * ── HUKUK VE EĞİTİM'İN ALT KAPISI YOK ──
 * (e) bendi öteki dört bentten farklı: yalnızca "A-U kategorileri arasından en
 * az 750 puan, toplamda en az 900 puan" diyor, A-C alt kapısını hiç
 * anmıyor. Öteki bentlere bakıp 200 puanlık kapıyı oraya da yazmak yönergenin
 * demediği bir kısıt olurdu; yazılmadı.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   Yabancı dil şartı yönergede geçmiyor; uydurulmadı.
 *   Doçentlikte "Doçentlik Sınav Yönetmeliği'nin Temel Alanları ile ilgili
 *       asgari başvuru koşullarını sağlamış olmak" ÜAK'ın kendi cetveline
 *       bağlı; ÜAK doçentlik unvanı beyanının içinde sayıldı.
 *   Yurt dışında doçentlik unvanı alanların eş düzey sayılması (2/b) usul
 *       hükmü, adayın sağlayacağı ayrı bir koşul değil.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/istanbul-zaim-2019.php
 */

use App\Enums\TemelAlan;
use App\Services\Scoring\Sart\Kalip;

$DOC = Kalip::DOCENTLIK_SONRASI;
$SON_DORT_YIL = Kalip::sonYil(4);

/** Dr. Öğr. Üyeliği ve doçentlikte alan ayrımı yok. */
$tumAlanlar = array_column(TemelAlan::cases(), 'value');

$yazarNotu = 'Yönergede çok yazarlı çalışmalar için paylaşım kuralı YOK; puanlar tam '
    .'veriliyor. Yazar çarpanı uygulayan üniversitelerle karşılaştırırken bunu hesaba katın.';

$kitapNotu = 'Uluslararası kitaplarınız alt kapıya saymaz: yönergenin uluslararası kitap '
    .'satırları kitabın yurt dışında ve tanınmış bir yabancı yayınevince basılmış olmasını '
    .'şart koşuyor, kaydınız bu ayrımı tutmadığı için kitaplarınız ulusal kitap satırına '
    .'düşüyor. Genel toplama girerler ama uluslararası makale ve bildiri kapısına girmezler.';

/**
 * "A-J kategorilerinden en az N puan" kapısı: uluslararası ve ulusal yayınlar,
 * çeviri, atıf, ders kitabı ve patent.
 *
 * @param  array<string, mixed>|null  $donem
 * @return array<string, mixed>
 */
$ajKapisi = function (int $puan, string $madde, ?array $donem = null): array {
    $ek = $donem === null ? '' : ' son dört yılda';

    return Kalip::puanDan(
        "Makale, bildiri, kitap, çeviri, atıf ve patent kalemlerinizden{$ek} en az {$puan} puan",
        ['A-J'], $puan, $donem, madde: $madde,
    );
};

/**
 * "A-U kategorilerinden en az N puan" kapısı: güzel sanatlar uygulamaları ve
 * idari görevler dışındaki her şey.
 *
 * @param  array<string, mixed>|null  $donem
 * @return array<string, mixed>
 */
$auKapisi = function (int $puan, string $madde, ?array $donem = null): array {
    $ek = $donem === null ? '' : ' son dört yılda';

    return Kalip::puanDan(
        "Güzel sanatlar uygulamaları ve idari görevler dışındaki kalemlerinizden{$ek} "
        ."en az {$puan} puan",
        ['A-U'], $puan, $donem, madde: $madde,
    );
};

/**
 * "A-C kategorilerinden en az N puan" kapısı. Cetvelin C bölümü boş kaldığı
 * için pratikte uluslararası makale ve bildiriden besleniyor; açıklama
 * adayın gerçekten sayılanı görmesi için ona göre yazıldı.
 *
 * @return array<string, mixed>
 */
$acKapisi = fn (int $puan, string $madde): array => Kalip::puanDan(
    "Uluslararası makale ve bildirilerinizden en az {$puan} puan",
    ['A-C'], $puan, madde: $madde,
);

/**
 * Profesörlük eşiği. Alanların tek farkı toplam baraj ve (e) bendinde alt
 * kapının hiç bulunmaması.
 *
 * @param  list<string>  $alanlar
 * @return array<string, mixed>
 */
$profesor = function (string $anahtar, array $alanlar, ?int $altKapi, int $toplam, string $madde) use ($acKapisi, $auKapisi, $yazarNotu, $kitapNotu): array {
    $cocuklar = [
        Kalip::beyan(
            'Doçentlik unvanınızı aldıktan sonra Üniversitelerarası Kurulun ilgili bilim '
            .'alanı için belirlediği doçentlik başvuru koşullarını sağlamış olmak',
            'Madde 3',
        ),
    ];

    if ($altKapi !== null) {
        $cocuklar[] = $acKapisi($altKapi, $madde);
    }

    $cocuklar[] = $auKapisi(750, $madde);
    $cocuklar[] = Kalip::toplam($toplam);

    $altKapiNotu = $altKapi === null
        ? 'Bu alanda uluslararası makale ve bildiri alt kapısı YOK; yönerge yalnızca iki '
            .'toplam istiyor. Öteki temel alanlarda 200 puanlık bir alt kapı var, buraya '
            .'yazılmadı çünkü yönerge bu bentte onu anmıyor.'
        : 'Alt kapı 200 puan. '.$kitapNotu;

    return [
        'anahtar' => "zaim-profesor-{$anahtar}",
        'aday_notu' => "Üç kapı var: doçentlik sonrasında ÜAK'ın alanınız için belirlediği "
            .'doçentlik başvuru koşullarını yeniden sağlamak, güzel sanatlar ve idari görev '
            ."dışındaki kalemlerden 750 puan ve tüm faaliyetlerden toplam {$toplam} puan. "
            .$altKapiNotu
            .' PUAN BARAJLARINA DÖNEM UYGULANMADI: yönergedeki "doçentlik unvanını aldıktan '
            .'sonra" ibaresi ÜAK koşullarını yeniden sağlama şartına bağlı, noktalı virgülden '
            .'sonraki puan bentlerine değil; 100-600-900 sıralaması da kariyer boyunca biriken '
            .'bir merdiven. Karşı okuma mümkün olduğu için başvurmadan önce üniversiteye teyit '
            .'ettirin. '.$yazarNotu,
        'universite' => 'İstanbul Sabahattin Zaim Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $alanlar,
        'cetvel' => 'istanbul-zaim-2019',
        'notlar' => "{$madde}: A-U kategorilerinden en az 750 puan, toplamda en az {$toplam} "
            .'puan'.($altKapi === null ? '. Bu bentte A-C alt kapısı yok.' : ", A-C kategorilerinden en az {$altKapi} puan.")
            .' Profesörlük paragrafı yalnızca beş temel alan sayıyor; anılmayan alanlara '
            .'(ilahiyat, güzel sanatlar, mimarlık, ziraat, spor) eşik yazılmadı.',
        'sart' => Kalip::ve('Profesör kadrosuna ilk kez atanma', $cocuklar),
    ];
};

$esikler = [
    [
        'anahtar' => 'zaim-dr',
        'aday_notu' => 'Tek kapı: makale, bildiri, kitap, çeviri, atıf ve patent '
            .'kalemlerinizden 100 puan. Proje, ödül, tez danışmanlığı, ders ve idari görev '
            .'puanlarınız bu kapıya girmez — yalnızca yayın ağırlıklı kalemler sayılıyor. '
            .'Tek bir SCI-Expanded, SSCI ya da AHCI makalesi (120 puan) kapıyı tek başına '
            .'açıyor. '.$yazarNotu,
        'universite' => 'İstanbul Sabahattin Zaim Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $tumAlanlar,
        'cetvel' => 'istanbul-zaim-2019',
        'notlar' => 'Madde 1: "Doktor Öğretim Üyesi kadrosuna ilk atamada, EK-I\'de belirtilen '
            .'A-J kategorileri arasından en az 100 puan karşılığı bilimsel etkinlikte '
            .'bulunmak." Alan ayrımı ve dönem kısıtı yok.',
        'sart' => $ajKapisi(100, 'Madde 1'),
    ],
    [
        'anahtar' => 'zaim-dr-yeniden',
        'aday_notu' => 'Yeniden atama dört yılda bir yapılıyor ve üç kapının üçü de SON DÖRT '
            .'YILDAKİ çalışmalarınıza bakıyor: yayın ağırlıklı kalemlerden 100, güzel sanatlar '
            .'ve idari görev dışındaki kalemlerden 150, tüm faaliyetlerden toplam 200 puan. '
            .'Yönerge dönemi son atama tarihinize değil sabit dört yıllık bir pencereye '
            .'bağladığı için bu eşik profilinize atama tarihi girmeseniz de hesaplanır. '
            .$yazarNotu,
        'universite' => 'İstanbul Sabahattin Zaim Üniversitesi',
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'alan' => $tumAlanlar,
        'cetvel' => 'istanbul-zaim-2019',
        'notlar' => 'Madde 1: "Yeniden atanacaklarda atanma öncesindeki dört yıl için; EK-I\'de '
            .'belirtilen A-J kategorilerinden en az 100 puan, A-U kategorileri arasından en az '
            .'150 puan, toplamda en az 200 puan." Dönem sabit dört yıllık pencere, son atama '
            .'tarihi değil.',
        'sart' => Kalip::ve('Dr. Öğr. Üyeliğine yeniden atanma', [
            $ajKapisi(100, 'Madde 1', $SON_DORT_YIL),
            $auKapisi(150, 'Madde 1', $SON_DORT_YIL),
            Kalip::toplam(200, $SON_DORT_YIL),
        ]),
    ],
    [
        'anahtar' => 'zaim-docent',
        'aday_notu' => 'Dört kapı var: ÜAK doçentlik unvanı, uluslararası makale ve '
            .'bildirilerinizden 100 puan, güzel sanatlar ve idari görev dışındaki kalemlerden '
            .'500 puan ve tüm faaliyetlerden toplam 600 puan. Yönerge dönem kısıtı koymuyor; '
            .'doktoradan önceki çalışmalarınız da sayılıyor. '.$kitapNotu.' '.$yazarNotu,
        'universite' => 'İstanbul Sabahattin Zaim Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $tumAlanlar,
        'cetvel' => 'istanbul-zaim-2019',
        'notlar' => 'Madde 2/c: "EK-I\'de belirtilen A-C kategorileri arasından en az 100 olmak '
            .'üzere A-U kategorileri arasından en az 500 puan, toplamda 600 puan." Madde 2/a '
            .'ÜAK doçentlik sınavını ve Doçentlik Sınav Yönetmeliği\'nin temel alan asgari '
            .'başvuru koşullarını şart koşuyor. Alan ayrımı ve dönem kısıtı yok.',
        'sart' => Kalip::ve('Doçent kadrosuna atanma', [
            Kalip::beyan(
                'Üniversitelerarası Kurul Başkanlığı doçentlik sınavını başarmış ve Doçentlik '
                .'Sınav Yönetmeliği\'nin temel alanınız için aradığı asgari başvuru koşullarını '
                .'sağlamış olmak',
                'Madde 2/a',
            ),
            $acKapisi(100, 'Madde 2/c'),
            $auKapisi(500, 'Madde 2/c'),
            Kalip::toplam(600),
        ]),
    ],

    // ── Profesörlük: yönergenin saydığı beş temel alan ──
    $profesor('sosyal', ['sosyal'], 200, 900, 'Madde 3/a'),
    $profesor('fen-muhendislik', ['fen', 'muhendislik'], 200, 1000, 'Madde 3/b'),
    $profesor('filoloji', ['filoloji'], 200, 900, 'Madde 3/c'),
    $profesor('saglik', ['saglik'], 200, 1000, 'Madde 3/d'),
    $profesor('hukuk-egitim', ['hukuk', 'egitim'], null, 900, 'Madde 3/e'),
];

/*
 * V. BÖLÜM (UYGULAMALI FAALİYETLER) YALNIZCA GÜZEL SANATLAR TEMEL ALANINDA.
 *
 * Kaynağın bölüm başlığı bunu birebir söylüyor: "V. UYGULAMALI FAALİYETLER
 * (Güzel Sanatlar Temel Alanında)". Şart ağaçları değişmiyor, yalnız eşiğin
 * bağlandığı CETVEL değişiyor; `guzel_sanatlar` V'yi taşıyan varyanta,
 * ötekiler taşımayan varyanta gidiyor. Anahtara alan EKLENMİYOR —
 * `SartDeposu::esikler()` zaten ekliyor.
 */
$bolunmus = [];

foreach ($esikler as $esik) {
    $alanlar = array_values(array_filter(
        $esik['alan'],
        fn (string $alan): bool => $alan !== 'guzel_sanatlar',
    ));

    if ($alanlar !== []) {
        $bolunmus[] = [...$esik, 'alan' => $alanlar];
    }

    if (in_array('guzel_sanatlar', $esik['alan'], true)) {
        $bolunmus[] = [...$esik,
            'alan' => ['guzel_sanatlar'],
            'cetvel' => 'istanbul-zaim-2019-guzel-sanatlar',
        ];
    }
}

return $bolunmus;
