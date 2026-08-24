<?php

/**
 * KARABÜK ÜNİVERSİTESİ — Öğretim Üyeliği Kadrolarına Yükseltilme ve Atanma
 * Yönergesi (Madde 6, 7, 8)
 * Kaynak: pdf/17536999092.karabukuniverstesi.pdf
 *
 * KORPUSTAKİ EN SADE YAPILARDAN BİRİ: temel alan ayrımı YOK. Karabük bütün
 * alanlardan aynı puanı istiyor, koşul iki satırdan ibaret — bir toplam baraj
 * ve "bunun en az N puanı 4.1-4.6 kısımlarından" alt barajı:
 *   Profesör   doçentlik sonrası toplam 1000, en az 400'ü 4.1-4.6'dan
 *   Doçent     doktora sonrası   toplam  800, en az 400'ü 4.1-4.6'dan
 *   Dr. ilk atama                toplam  250, en az 150'si 4.1-4.6'dan
 *
 * TEK İSTİSNA TIP/DİŞ/ECZACILIK/VETERİNERLİK FAKÜLTELERİ (Madde 8/A-ç): bu
 * kadrolara başvuran Dr. Öğr. Üyesi adaylarında alt baraj hiç aranmıyor,
 * yalnızca toplam 150 puan isteniyor. Bu ayrım temel alanla değil BİRİMLE
 * ilgili olduğu için `birim` alanıyla girildi: Sağlık Bilimleri alanında iki
 * eşik var ve doğrusunu seçebilmek için adayın birimini belirtmesi gerekiyor.
 *
 * YENİDEN ATANMA GİRİLMEDİ (Madde 8/B): son atama sonrası toplam 450 (tıp vb.
 * fakültelerde 225) isteniyor, ama yönerge bu sayıların "bir önceki atamanın 3
 * yıl süre ile yapılmış olması durumunda geçerli" olduğunu, farklı sürelerde
 * "oransal hesaplama yapılır" dediğini ekliyor. Atama süresi profilde tutulmuyor;
 * sabit 450 yazmak 2 yıllık atanan adaya yanlış baraj gösterirdi. Koşul aday
 * notunda anıldı.
 *
 * PROFESÖRLÜKTE BAŞLICA ESER KOŞULU (Madde 6/ç-d) beyan olarak duruyor: aday
 * eserlerinden birini başvuru formunda başlıca eser olarak belirtmeli; Güzel
 * Sanatlar adayları bunun yerine gerçekleştirilmiş kişisel mimarlık, sergi,
 * konser veya tasarım etkinliğini gösterebiliyor.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/karabuk-2024.php
 */

use App\Services\Scoring\Sart\Kalip;

$DR = Kalip::DOKTORA_SONRASI;
$DOC = Kalip::DOCENTLIK_SONRASI;

/** Karabük alan ayrımı yapmıyor; cetveldeki bütün temel alanlar. */
$tumAlanlar = ['fen', 'muhendislik', 'mimarlik', 'saglik', 'spor', 'hukuk', 'ilahiyat',
    'filoloji', 'sosyal', 'egitim', 'guzel_sanatlar', 'ziraat'];

/** Tıp/diş/eczacılık/veterinerlik istisnası yalnızca Sağlık Bilimleri'nde doğar. */
$saglikDisi = array_values(array_filter($tumAlanlar, fn (string $a) => $a !== 'saglik'));

$tipFakulteleri = 'Tıp, Diş Hekimliği, Eczacılık ve Veterinerlik Fakülteleri';
$digerSaglik = 'Diğer Sağlık Bilimleri birimleri';

$yenidenAtamaNotu = 'Yeniden atanmada (Madde 8/B) son atama tarihinden sonraki eserlerinizle '
    .'toplam 450 puan, bunun en az 225\'i makale, bildiri, kitap, çeviri ve sanat '
    .'kalemlerinden isteniyor; tıp, diş hekimliği, eczacılık ve veterinerlik fakültelerinde '
    .'toplam 225, en az 75\'i aynı kalemlerden. Bu sayılar bir önceki atamanın 3 yıl süreyle '
    .'yapılmış olması durumunda geçerli, farklı sürelerde oransal hesaplanıyor; atama süresi '
    .'burada tutulmadığı için yeniden atanma eşiği girilmedi.';

/**
 * Dr. Öğr. Üyesi ilk atama eşiği. Alt baraj yoksa yalnızca toplam sorulur.
 *
 * @param  list<string>  $alanlar
 * @return array<string, mixed>
 */
$drIlkAtama = function (string $anahtar, array $alanlar, ?string $birim, int $toplam, ?int $alt) use ($yenidenAtamaNotu): array {
    $cocuklar = [Kalip::toplam($toplam)];

    if ($alt !== null) {
        $cocuklar[] = Kalip::puanDan(
            "Makale, bildiri, kitap, çeviri ve sanat etkinliği kalemlerinizden en az {$alt} puan",
            ['4.1-4.6'], $alt, madde: 'Madde 8/A-ç',
        );
    }

    $cocuklar[] = Kalip::beyan('Doktora, uzmanlık veya sanatta yeterlik unvanına sahip olmak; '
        .'yurt dışında tamamlananların denkliğinin kabul edilmiş olması', 'Madde 8/A-b-c');

    return [
        'anahtar' => "karabuk-dr-{$anahtar}",
        'aday_notu' => $yenidenAtamaNotu,
        'universite' => 'Karabük Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => array_values($alanlar),
        'birim' => $birim,
        'cetvel' => 'karabuk-2024',
        'notlar' => $alt === null
            ? "Madde 8/A-ç: tıp, diş hekimliği, eczacılık ve veterinerlik fakültelerinde EK-1'den toplam {$toplam} puan; alt baraj yok."
            : "Madde 8/A-ç: EK-1'den toplam {$toplam} puan, bunun en az {$alt} puanı 4.1-4.6 kısımlarından.",
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Karabük Üniversitesi', $cocuklar),
    ];
};

return [
    // ══════════ DR. ÖĞRETİM ÜYESİ (ilk atama, Madde 8/A) ══════════
    $drIlkAtama('genel', $saglikDisi, null, 250, 150),
    $drIlkAtama('saglik-tip', ['saglik'], $tipFakulteleri, 150, null),
    $drIlkAtama('saglik-diger', ['saglik'], $digerSaglik, 250, 150),

    // ══════════ DOÇENT (Madde 7) ══════════
    [
        'anahtar' => 'karabuk-docent',
        'aday_notu' => 'Karabük doçentlikte temel alan ayrımı yapmıyor; bütün alanlarda aynı '
            .'sayılar geçerli. Puanların tamamı doktora unvanınızı aldıktan sonraki '
            .'çalışmalarınızdan gelmeli.',
        'universite' => 'Karabük Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $tumAlanlar,
        'cetvel' => 'karabuk-2024',
        'notlar' => 'Madde 7/ç: doktora sonrası EK-1\'den toplam 800 puan, bunun en az 400 puanı '
            .'4.1, 4.2, 4.3, 4.4, 4.5 ve 4.6 kısımlarından.',
        'sart' => Kalip::ve('Doçent — Karabük Üniversitesi', [
            Kalip::toplam(800, $DR),
            Kalip::puanDan('Makale, bildiri, kitap, çeviri ve sanat etkinliği kalemlerinizden en az 400 puan',
                ['4.1-4.6'], 400, $DR, madde: 'Madde 7/ç'),
            Kalip::beyan('Üniversitelerarası Kurul tarafından verilen doçent unvanını almış olmak; '
                .'yurt dışından alınmışsa denkliğinin kabul edilmiş olması', 'Madde 7/b-c'),
        ]),
    ],

    // ══════════ PROFESÖR (Madde 6) ══════════
    [
        'anahtar' => 'karabuk-profesor',
        'aday_notu' => 'Karabük profesörlükte de temel alan ayrımı yapmıyor. Puanların tamamı '
            .'doçentlik unvanınızı aldıktan sonraki çalışmalarınızdan gelmeli. Güzel Sanatlar '
            .'adayları başlıca eser yerine gerçekleştirilmiş kişisel mimarlık, planlama, sergi, '
            .'konser, sanat veya tasarım etkinliğini gösterebiliyor.',
        'universite' => 'Karabük Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $tumAlanlar,
        'cetvel' => 'karabuk-2024',
        'notlar' => 'Madde 6/e: doçentlik sonrası EK-1\'den toplam 1000 puan, bunun en az 400 '
            .'puanı 4.1, 4.2, 4.3, 4.4, 4.5 ve 4.6 kısımlarından.',
        'sart' => Kalip::ve('Profesör — Karabük Üniversitesi', [
            Kalip::toplam(1000, $DOC),
            Kalip::puanDan('Makale, bildiri, kitap, çeviri ve sanat etkinliği kalemlerinizden en az 400 puan',
                ['4.1-4.6'], 400, $DOC, madde: 'Madde 6/e'),
            Kalip::beyan('Doçentlik unvanını aldıktan sonra en az 5 yıl süreyle ilgili bilim veya '
                .'sanat alanında çalışmış olmak', 'Madde 6/c'),
            Kalip::beyan('Kadro ilanındaki bilim alanıyla ilgili en az bir eserinizi başvuru '
                .'formunda başlıca eser olarak belirtmiş olmak', 'Madde 6/ç-d'),
        ]),
    ],
];
