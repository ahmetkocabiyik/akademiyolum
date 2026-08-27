<?php

/**
 * DİCLE ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma Yönergesi
 * Kaynak: pdf/17536992572.dicleuniverstesi.pdf (24 sayfa)
 *
 * ── YAPI: DÖRT TEMEL BİLİM, AYNI İSKELET ──
 * Madde 12-15 dört temel bilim grubu için neredeyse aynı iskeleti tekrar
 * ediyor; farklar yalnızca (a) hangi makale kod aralığının zorunlu olduğu
 * ve (b) yeniden atanma ile doçentlik-profesörlükte hangi etkinlik
 * kümesinin sayıldığı:
 *
 *   Madde 12 SAYISAL BİLİMLER            → A1 zorunlu, küme M1-M2
 *   Madde 13 SOSYAL, BEŞERİ VE EĞİTİM    → A1 veya A3, küme M1-M2
 *   Madde 14 MİMARLIK, GÜZEL SANATLAR,   → A1 veya A3; küme mimarlıkta
 *            KONSERVATUVAR                 M1-M2, güzel sanatlarda M1-M4,
 *                                          konservatuvarda M1-M2 + N1-N2
 *   Madde 15 SPOR BİLİMLERİ              → A1 veya A3, küme M1-M2 ve T
 *
 * Puan barajları dört grupta da aynı: Dr. ilk atanma 40 · yeniden atanma 40
 * (telafiyle 60) · doçent 100 · profesör 300.
 *
 * ── MADDE 10'UN BİRİM LİSTESİ → temel alan EŞLEMESİ ──
 *   Sayısal Bilimler (Diş, Eczacılık, Tıp, Veteriner, Mühendislik, Ziraat,
 *       Fen fakülteleri) → saglik, muhendislik, fen, ziraat
 *   Sosyal, Beşeri ve Eğitim Bilimleri (Edebiyat, Hukuk, İİBF, İlahiyat,
 *       Eğitim, İletişim) → sosyal, hukuk, ilahiyat, egitim, filoloji
 *   Mimarlık, Güzel Sanatlar ve Konservatuvar → mimarlik, guzel_sanatlar
 *   Spor Bilimleri → spor
 *
 * Madde 14 üç ayrı alanı tek maddede topluyor ama kümeleri farklı
 * (mimarlıkta M1-M2, güzel sanatlarda M1-M4, konservatuvarda M1-M2+N1-N2);
 * mimarlık kendi temel alanına düştüğü için `birim`e ihtiyaç duymuyor, ama
 * Güzel Sanatlar ile Konservatuvar ikisi de `guzel_sanatlar`a düştüğünden
 * `birim` ile ayrıldı.
 *
 * ── KOŞULLAR KOD ARALIĞINA ATIF YAPIYOR ──
 * "A1-A2 kodları arasındaki faaliyetlerden en az 20 puan", "A1-D2 kodları
 * arasından ilave 50 puan", "M1-M2 kodlarından en az 10 puan" — bu yüzden
 * EK-1'in kodları cetvelde birebir korundu ve `gruplar` altında aralıklar
 * tanımlandı.
 *
 * ── TELAFİLERİN TAMAMI YAZILDI ──
 * Yönergenin en belirgin deseni: neredeyse her ek koşulun "sağlayamayan
 * adayların bunun yerine şu kadar puan daha alması" alternatifi var. Hepsi
 * motorun `telafi` dalıyla karşılandı:
 *   Dr. yeniden atanma: proje/tertip kurulu koşulu → A1-D2'den 20 puan
 *       daha (toplam 40 yerine 60).
 *   Doçent: proje yürütücülüğü → A1-D2'den 50 puan daha;
 *           M kümesi 10 puan → A1-A2 (ya da A1-A3) 10 puan daha.
 *   Profesör: proje yürütücülüğü → 50 puan daha; M kümesi 15 puan → 15
 *           puan daha; J1-J2 tez yönetimi 15 puan → 10 puan daha.
 *
 * ── YENİDEN ATANMANIN "EN AZ 2 FAALİYET" KOŞULU ──
 * Madde 12/A-3: "A-D ve M1-M2 kodları arasındaki faaliyetlerden en az 2
 * faaliyet içermek (a. A1-A2'den en az 20 puan (zorunlu), b. proje
 * ekibinde yer almak veya bilimsel toplantı tertip kurullarında görev
 * almak)". Yani (a) zorunlu, (b) telafili; "en az 2 faaliyet" ise ayrı bir
 * adet koşulu. Üçü de yazıldı.
 *
 * ── ATIF KOŞULU YALNIZCA PROFESÖRLÜKTE ──
 * Madde 12-15/C-5: "L kodu (atıf) alanından en az 10 puan". Doçentlikte
 * atıf koşulu YOK; kaynağa sadık kalındı.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   Madde 12-15/C-1 (2547 sayılı Kanunun 26. maddesindeki süre koşulları)
 *       ve C-3'ün "doçentlik asgari başvuru koşullarını yeniden karşılamış
 *       olmak" ifadesi — süre bilgisi ve ÜAK'ın o dönemki koşulları
 *       profilde yok; beyan olarak eklendi.
 *   Madde 12-15/C-2 (başlıca araştırma eseri göstermek) — adayın kendi
 *       seçimi; beyan.
 *   Madde 12-15'in NOT'u ("bir madde için kullanılan faaliyet başka bir
 *       madde için kullanılamaz") — motor bir faaliyeti birden çok koşulda
 *       sayabiliyor; bu kural uygulanamadı ve aday olduğundan HAZIR
 *       görünebilir. Aday notunda uyarıldı.
 *   Madde 7'nin doğum, askerlik ve sağlık raporu nedeniyle süre uzatımı
 *       hükümleri — kişisel duruma bağlı.
 *   Madde 11'in "yabancı dille öğretim yapan bölümlerde ayrı esaslar"
 *       istisnası — birimin eğitim dili profilde yok; genel YDS 60 şartı
 *       yazıldı.
 *
 * ── SPOR BİLİMLERİNİN T KÜMESİ CETVELE GİREMEDİ ──
 * Madde 15 yeniden atanmada "A1-A3, T1-T8 ve M1-M2", doçentlik ve
 * profesörlükte "M1-M2 kodları arasındaki ve T kodundaki faaliyetler"
 * diyor. T (sportif faaliyetler) bölümünün tamamı sözlükte karşılıksız
 * olduğu için küme yalnızca M1-M2'ye indi; spor adayı bu koşulda
 * olduğundan ZOR bir eşik görür ve aday notunda uyarılıyor.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/dicle-2023.php
 */

use App\Services\Scoring\Sart\Kalip;

$CETVEL = 'dicle-2023';
$UNIVERSITE = 'Dicle Üniversitesi';
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;
$SON_ATAMA = Kalip::SON_ATAMA_SONRASI;

/**
 * "Sağlayamayan adayların bunun yerine şu kümeden N puan daha alması"
 * telafisini bir düğüme ekler.
 *
 * @param  array<string, mixed>  $dugum
 * @param  list<string>  $maddeler
 * @param  array<string, mixed>|null  $donem
 * @return array<string, mixed>
 */
$telafili = function (array $dugum, string $aciklama, array $maddeler, int $puan, ?array $donem, string $madde): array {
    return $dugum + [
        'telafi' => [
            'tip' => 'puan',
            'aciklama' => $aciklama,
            'madde' => $madde,
            'maddeler' => $maddeler,
            'min_puan' => $puan,
            'donem' => $donem,
        ],
    ];
};

/**
 * Bir temel bilim grubunun dört kadrosunu üretir.
 *
 * @param  list<string>  $alanlar
 * @param  list<string>  $makaleKume  Zorunlu makale kod aralığı (A1 ya da A1-A3)
 * @param  list<string>  $etkinlikKume  M kümesi (alan grubuna göre değişiyor)
 * @return list<array<string, mixed>>
 */
$grup = function (
    string $anahtar, string $ad, array $alanlar, ?string $birim,
    array $makaleKume, string $makaleMetni, array $etkinlikKume, string $etkinlikMetni, string $madde,
) use ($UNIVERSITE, $CETVEL, $DOCENTLIK, $SON_ATAMA, $telafili): array {
    $makaleKume = array_values($makaleKume);
    $etkinlikKume = array_values($etkinlikKume);

    return [
        // ── Dr. Öğr. Üyesi ilk atanma ──
        [
            'anahtar' => "dicle-{$anahtar}-dr",
            'aday_notu' => "Dicle'de ilk atanma eşiği düşük ama iki koşullu: {$makaleMetni} "
                .'birinci isim olarak en az 1 makaleniz olmalı ve EK-1 faaliyetlerinden toplam '
                .'en az 40 puan almalısınız. Merkezi yabancı dil sınavından en az 60 puan şart. '
                .'DİKKAT: yönerge "bir madde için kullanılan faaliyet başka bir madde için '
                .'kullanılamaz" diyor; bu kural burada uygulanamıyor, aynı yayınınız birden '
                .'fazla koşulu birden karşılıyor görünebilir.',
            'universite' => $UNIVERSITE,
            'kadro' => 'dr_ogr_uyesi',
            'alan' => $alanlar,
            'birim' => $birim,
            'cetvel' => $CETVEL,
            'notlar' => "{$madde}/A ({$ad}): EK-1'den asgari 40 puan; birinci isim olarak "
                .'en az 1 makale; Madde 11 YDS 60.',
            'sart' => Kalip::ve("Doktor Öğretim Üyesi kadrosuna ilk atanma — {$ad}", [
                Kalip::yds(60),
                Kalip::beyan('Doktora ya da tıpta, diş hekimliğinde, veteriner hekimlikte uzmanlık veya sanatta yeterlik derecesine sahip olmak', $madde),
                Kalip::adet("{$makaleMetni} birinci isim olarak en az 1 makaleniz olmalı", $makaleKume, 1, yazar: 'ilk', madde: "{$madde}/A-2"),
                Kalip::toplam(40),
            ]),
        ],
        // ── Dr. Öğr. Üyesi yeniden atanma ──
        [
            'anahtar' => "dicle-{$anahtar}-dr-yeniden",
            'aday_notu' => 'Yeniden atanmada bütün koşullar SON ATAMANIZDAN SONRAKİ '
                ."çalışmalarınızdan sağlanmalı: {$makaleMetni} en az 20 puan (zorunlu), "
                .'makale, bildiri, kitap, proje ve kongre düzenleme kalemlerinizden en az 2 '
                .'faaliyet ve toplamda en az 40 puan. Ayrıca bir proje ekibinde ya da bilimsel '
                .'toplantı tertip kurulunda görev almış olmalısınız; bunu sağlayamazsanız '
                .'toplam puanınızı 60\'a tamamlamanız gerekiyor. Yeniden atanmada yabancı dil '
                .'şartı aranmaz.',
            'universite' => $UNIVERSITE,
            'kadro' => 'dr_ogr_uyesi_yeniden',
            'alan' => $alanlar,
            'birim' => $birim,
            'cetvel' => $CETVEL,
            'notlar' => "{$madde}/A-3 ({$ad}): A-D ve M1-M2'den en az 2 faaliyet; "
                .'zorunlu alt baraj 20 puan; proje/tertip kurulu koşulunun telafisi A1-D2\'den '
                .'20 puan daha (toplam 60); toplam 40 puan. Hepsi son atama sonrası.',
            'sart' => Kalip::ve("Doktor Öğretim Üyeliğine yeniden atanma — {$ad}", [
                Kalip::puanDan("Son atamanızdan sonra {$makaleMetni} en az 20 puan", $makaleKume, 20, $SON_ATAMA, madde: "{$madde}/A-3-a"),
                Kalip::adet('Son atamanızdan sonra makale, bildiri, kitap, proje ve kongre düzenleme kalemlerinizden en az 2 faaliyetiniz olmalı', ['A-D-M'], 2, donem: $SON_ATAMA, madde: "{$madde}/A-3"),
                $telafili(
                    Kalip::adet('Son atamanızdan sonra bir proje ekibinde ya da bilimsel toplantı tertip kurulunda görev almış olmalısınız', ['D1-D5', 'M1-M2'], 1, donem: $SON_ATAMA, madde: "{$madde}/A-3-b"),
                    'Bu koşulu sağlayamazsanız: makale, bildiri, kitap ve proje kalemlerinizden 20 puan daha alarak toplamınızı 60\'a tamamlamalısınız',
                    ['A1-D2'], 60, $SON_ATAMA, "{$madde}/A-3",
                ),
                Kalip::toplam(40, $SON_ATAMA),
            ]),
        ],
        // ── Doçent ──
        [
            'anahtar' => "dicle-{$anahtar}-docent",
            'aday_notu' => 'Doçentlikte EK-1 faaliyetlerinden toplam en az 100 puan gerekiyor. '
                .'Ayrıca BAP hariç en az bir proje yürütücülüğü (sağlayamazsanız makale, '
                .'bildiri, kitap ve proje kalemlerinizden 50 puan daha) ve '
                ."{$etkinlikMetni} en az 10 puan (sağlayamazsanız {$makaleMetni} 10 puan daha) "
                .'şart. Doçentlik unvanına sahip olmalısınız.',
            'universite' => $UNIVERSITE,
            'kadro' => 'docentlik',
            'alan' => $alanlar,
            'birim' => $birim,
            'cetvel' => $CETVEL,
            'notlar' => "{$madde}/B ({$ad}): EK-1'den asgari 100 puan; en az bir proje "
                .'yürütücülüğü (telafi: A1-D2\'den 50 puan); etkinlik kümesinden 10 puan '
                .'(telafi: makale kümesinden 10 puan).',
            'sart' => Kalip::ve("Doçent kadrosuna atanma — {$ad}", [
                Kalip::beyan('Başvurduğunuz alanda Üniversitelerarası Kuruldan doçentlik unvanı almış olmak', "{$madde}/B-1"),
                $telafili(
                    Kalip::adet('BAP hariç en az 1 projede yürütücü olmalısınız', ['D1a-D2a'], 1, madde: "{$madde}/B-2"),
                    'Bu koşulu sağlayamazsanız: makale, bildiri, kitap ve proje kalemlerinizden 50 puan daha almalısınız',
                    ['A1-D2'], 50, null, "{$madde}/B-2",
                ),
                $telafili(
                    Kalip::puanDan("{$etkinlikMetni} en az 10 puan", $etkinlikKume, 10, madde: "{$madde}/B-3"),
                    "Bu koşulu sağlayamazsanız: {$makaleMetni} 10 puan daha almalısınız",
                    $makaleKume, 10, null, "{$madde}/B-3",
                ),
                Kalip::toplam(100),
            ]),
        ],
        // ── Profesör ──
        [
            'anahtar' => "dicle-{$anahtar}-profesor",
            'aday_notu' => 'Profesörlükte EK-1 faaliyetlerinden toplam en az 300 puan gerekiyor '
                .'(doçentlik başvurunuzdaki puanlar da bu 300\'ün içinde sayılıyor). Doçentlik '
                ."unvanınızdan sonra {$makaleMetni} birinci isim olarak en az 1 makaleniz ve en "
                .'az bir proje yürütücülüğünüz olmalı; atıf kalemlerinizden en az 10 puan, '
                ."{$etkinlikMetni} en az 15 puan ve lisansüstü tez yönetiminden en az 15 puan "
                .'aranıyor. Bu koşulların her birinin puanla telafisi var.',
            'universite' => $UNIVERSITE,
            'kadro' => 'profesorluk',
            'alan' => $alanlar,
            'birim' => $birim,
            'cetvel' => $CETVEL,
            'notlar' => "{$madde}/C ({$ad}): EK-1'den toplam 300 puan; doçentlik sonrası "
                .'birinci isim 1 makale; L kodundan 10 puan; proje yürütücülüğü (telafi 50 '
                .'puan); etkinlik kümesinden 15 puan (telafi 15 puan); J1-J2\'den 15 puan '
                .'(telafi 10 puan).',
            'sart' => Kalip::ve("Profesör kadrosuna atanma — {$ad}", [
                Kalip::beyan('2547 sayılı Kanunun 26. maddesindeki süre koşullarını doçentlik unvanınızı aldığınız tarihten itibaren tamamlamış olmak', "{$madde}/C-1"),
                Kalip::beyan('Doçentlik unvanınızdan sonraki eserlerinizden birini başlıca araştırma eseri olarak göstermek', "{$madde}/C-2"),
                Kalip::beyan('Doçentlik unvanınızı aldığınız döneme ait doçentlik asgari başvuru koşullarını doçentlik sonrasında yeniden karşılamış olmak', "{$madde}/C-3"),
                Kalip::adet("Doçentlik unvanınızdan sonra {$makaleMetni} birinci isim olarak en az 1 makaleniz olmalı", $makaleKume, 1, yazar: 'ilk', donem: $DOCENTLIK, madde: "{$madde}/C-4"),
                Kalip::puanDan('Atıf kalemlerinizden en az 10 puan', ['L'], 10, madde: "{$madde}/C-5"),
                $telafili(
                    Kalip::adet('Doçentlik unvanınızdan sonra BAP hariç en az 1 projede yürütücü olmalısınız', ['D1a-D2a'], 1, donem: $DOCENTLIK, madde: "{$madde}/C-6"),
                    'Bu koşulu sağlayamazsanız: makale, bildiri, kitap ve proje kalemlerinizden 50 puan daha almalısınız',
                    ['A1-D2'], 50, null, "{$madde}/C-6",
                ),
                $telafili(
                    Kalip::puanDan("Doçentlik unvanınızdan sonra {$etkinlikMetni} en az 15 puan", $etkinlikKume, 15, $DOCENTLIK, madde: "{$madde}/C-7"),
                    "Bu koşulu sağlayamazsanız: {$makaleMetni} 15 puan daha almalısınız",
                    $makaleKume, 15, null, "{$madde}/C-7",
                ),
                $telafili(
                    Kalip::puanDan('Lisansüstü tez yönetiminden en az 15 puan', ['J1-J2'], 15, madde: "{$madde}/C-8"),
                    "Bu koşulu sağlayamazsanız: {$makaleMetni} 10 puan daha almalısınız",
                    $makaleKume, 10, null, "{$madde}/C-8",
                ),
                Kalip::toplam(300),
            ]),
        ],
    ];
};

$esikler = [];

$MAKALE_A1 = 'SCI, SCI-Expanded, SSCI veya AHCI dergilerinde';
$MAKALE_A1_A3 = 'SCI-AHCI ya da uluslararası alan endeksli dergilerde';
$ETKINLIK_M = 'kongre ve sempozyum düzenleme kalemlerinizden';

$esikler = array_merge($esikler, $grup(
    'sayisal', 'Sayısal Bilimler', ['saglik', 'muhendislik', 'fen', 'ziraat'], null,
    ['A1'], $MAKALE_A1, ['M1-M2'], $ETKINLIK_M, 'Madde 12',
));

$esikler = array_merge($esikler, $grup(
    'sosyal', 'Sosyal, Beşeri Bilimler ve Eğitim Bilimleri',
    ['sosyal', 'hukuk', 'ilahiyat', 'egitim', 'filoloji'], null,
    ['A1-A3'], $MAKALE_A1_A3, ['M1-M2'], $ETKINLIK_M, 'Madde 13',
));

$esikler = array_merge($esikler, $grup(
    'mimarlik', 'Mimarlık', ['mimarlik'], null,
    ['A1-A3'], $MAKALE_A1_A3, ['M1-M2'], $ETKINLIK_M, 'Madde 14',
));

$esikler = array_merge($esikler, $grup(
    'guzel-sanatlar', 'Güzel Sanatlar', ['guzel_sanatlar'], 'Güzel Sanatlar Fakültesi',
    ['A1-A3'], $MAKALE_A1_A3, ['M1-M4'],
    'kongre düzenleme ile sergi, bienal ve koleksiyon kalemlerinizden', 'Madde 14',
));

$esikler = array_merge($esikler, $grup(
    'konservatuvar', 'Konservatuvar', ['guzel_sanatlar'], 'Devlet Konservatuvarı',
    ['A1-A3'], $MAKALE_A1_A3, ['M1-M2-N1-N2'],
    'kongre düzenleme ile müzik ve sahne yapıtı kalemlerinizden', 'Madde 14',
));

$esikler = array_merge($esikler, $grup(
    'spor', 'Spor Bilimleri', ['spor'], null,
    ['A1-A3'], $MAKALE_A1_A3, ['M1-M2'],
    'kongre ve sempozyum düzenleme kalemlerinizden (yönergenin saydığı sportif faaliyetler faaliyet kaydına girilemediği için bu kümeye dâhil edilemedi)',
    'Madde 15',
));

return $esikler;
