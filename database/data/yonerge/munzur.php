<?php

/**
 * MUNZUR ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma İlkeleri
 * Kaynak: pdf/17634002431.Munzur Üniversitesi Kriter.pdf (19 sayfa,
 *         Genel Sekreter Vekili onayı 20.06.2025)
 *
 * BİLİM ALANLARI ÜNİVERSİTENİN KENDİ TANIMI (Madde 4), ÜAK temel alanları
 * değil. Eşleme:
 *   Sağlık Bilimleri            → saglik
 *   Mühendislik Bilimleri       → muhendislik
 *   Fen Bilimleri (Fen VE SU ÜRÜNLERİ fakülteleri) → fen, ziraat
 *   Sosyal Bilimler (İnsani ve Sosyal, İİBF, Edebiyat, Eğitim Bilimleri,
 *                    İletişim, SPOR BİLİMLERİ) → sosyal, filoloji, egitim, spor
 *   Mimarlık Bilimleri          → mimarlik
 *   Güzel Sanatlar Bilimleri    → guzel_sanatlar
 * HUKUK VE İLAHİYAT HİÇ ANILMIYOR — Munzur'da o fakülteler yok. İki alan için
 * eşik YAZILMADI; kapsam dışı kalmaları doğrusu.
 *
 * SPOR BİLİMLERİ SOSYAL BİLİMLERE DÂHİL, bu yüzden spor adayı da SCI, SSCI ve
 * AHCI makalelerinde 1,5 katı puan alıyor ve sosyal barajlarına tabi.
 *
 * MATEMATİK VE İSTATİSTİK `birim` İLE AYRILDI: doçentlikte ve profesörlükte
 * "Matematik ve istatistik dışındaki bilim alanlarında C kapsamında toplamda
 * en az 60 / 70 puan" deniyor, yani bu iki alt alanın C koşulu YOK. Aynı
 * (üniversite, kadro, fen) üçlüsünde iki eşik doğduğu için ayrım yalnız
 * `birim` ile kurulabiliyor.
 *
 * BARAJ SANAT ALANLARINDA BELİRGİN BİÇİMDE DÜŞÜK. Toplam puan:
 *   Dr. Öğr. Üyesi   Mimarlık ve Güzel Sanatlar  75 · diğerleri 100
 *   Doçent           Mimarlık ve Güzel Sanatlar 250 · diğerleri 400
 *   Profesör         Mimarlık ve Güzel Sanatlar 350 · diğerleri 450
 *
 * "A1 KAPSAMINDA EN FAZLA N PUAN" TAVANI KADRO BAŞINA CETVEL VARYANTI ÜRETTİ:
 * doçentlikte 30 (Güzel Sanatlarda 20), profesörlükte 50 (Güzel Sanatlarda
 * 30), Dr. Öğr. Üyeliğinde tavan yok. Yedi varyantın hangisinin hangi eşiğe
 * bağlandığı aşağıda `cetvel` alanında görülüyor.
 *
 * SOSYAL BİLİMLERİN DR. ŞARTI İKİ KATMANLI (Madde 10/2-ç): "hakemli
 * dergilerde A2, A3, A4, B2 kapsamındaki yayınlardan en az 20 puan olmak
 * koşuluyla A1, A2, A3 ve B1, B2 kapsamındaki faaliyetlerden toplamda en az
 * 75 puan". Öteki alanlarda tek koşul var.
 *
 * "LİSANSÜSTÜ TEZLERİ KAPSAMI DIŞINDA OLMAK" FİLTRESİ UYGULANAMIYOR.
 * Doçentlik ve profesörlük zorunlu puanları tezden üretilmiş yayınları
 * dışarıda bırakıyor; kayıt bir yayının tezden üretilip üretilmediğini yalnız
 * aday tez yayını olarak kaydettiyse biliyor. Aday notunda uyarıldı; bu,
 * adayın zorunlu puanını OLDUĞUNDAN YÜKSEK gösterebilir.
 *
 * DR. ÖĞR. ÜYESİ YENİDEN ATANMA GİRİLMEDİ (Madde 10/3): "iki yılda bir,
 * öngörülen toplam asgari puanların 1/3'ü"; atama tarihi profilde yok.
 * Madde 13'ün askerlik, sağlık ve doğum izni istisnası da aynı sebeple.
 *
 * PROFESÖRLÜĞÜN ÜAK KOŞULU BEYAN (Madde 12/1-a): "doçent unvanını aldıktan
 * sonra geçen sürede, başvuru yaptığı dönemdeki doçentlik şartlarını akademik
 * faaliyetleri bakımından tekrar sağlamak (lisansüstü tezlerden en az bir
 * yayın zorunluluğu hariç)".
 *
 * PUANLAMA BAĞLAYICI DEĞİL (Madde 5/b ve 9/1-c): yönerge "adayın yüksek puan
 * almış olması atanması için yeterli bir ölçüt değildir" ve "ön değerlendirme
 * koşullarının sağlanması adaylar için bağlayıcı bir hak oluşturmaz" diyor.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: munzur-2025*
 */

use App\Services\Scoring\Sart\Kalip;

$UNI = 'Munzur Üniversitesi';
$DOKTORA = Kalip::DOKTORA_SONRASI;
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;

$baglayiciDegil = 'Munzur yönergesi puanlamanın tek başına yeterli olmadığını açıkça yazıyor '
    .'(Madde 5/b ve 9/1-c): yüksek puan atanma için yeterli değil, ön değerlendirme koşullarını '
    .'sağlamak adaya bağlayıcı bir hak vermiyor. Jüri ayrıca yayınlarınızın sürekliliğini, '
    .'aldığınız atıfları ve eğitime katkınızı değerlendiriyor.';

$tezFiltresi = 'Doçentlik ve profesörlük zorunlu puanları LİSANSÜSTÜ TEZLERİNİZDEN ÜRETİLMİŞ '
    .'yayınları dışarıda bırakıyor; bu filtre burada uygulanamıyor, o yüzden zorunlu puanınız '
    .'olduğundan yüksek görünebilir. Tezinizden ürettiğiniz yayınları tez yayını olarak '
    .'kaydederseniz ayrım netleşir.';

$yenidenAtanma = 'Doktor öğretim üyeliğine YENİDEN ATANMA eşiği girilmedi: koşul "iki yılda bir, '
    .'öngörülen toplam asgari puanın 1/3\'ünü yeniden sağlamak" biçiminde ve son atanma '
    .'tarihinize bağlı.';

$dilBeyani = Kalip::yds(55);

$drBeyani = Kalip::beyan('Doktora, sanatta yeterlik ya da tıpta uzmanlık unvanını kazanmış olmak',
    'Madde 10/1-a');
$docentlikBeyani = Kalip::beyan('Doçent unvanını kazanmış olmak', 'Madde 11/1-a');
$profesorlukBeyani = Kalip::beyan('Doçent unvanını aldıktan sonra geçen sürede, başvuru '
    .'yaptığınız dönemdeki ÜAK doçentlik şartlarını akademik faaliyetleriniz bakımından tekrar '
    .'sağlamış olmak (lisansüstü tezlerden en az bir yayın zorunluluğu hariç)', 'Madde 12/1-a');

/**
 * @param  list<string>  $alanlar
 * @param  list<array<string, mixed>>  $cocuklar
 * @return array<string, mixed>
 */
$esik = function (string $anahtar, string $kadro, string $kadroAd, array $alanlar, string $cetvel,
    int $toplam, ?array $donem, array $cocuklar, string $notlar, string $adayNotu,
    ?string $birim = null) use ($UNI, $dilBeyani): array {
    $kayit = [
        'anahtar' => "munzur-{$anahtar}",
        'aday_notu' => $adayNotu,
        'universite' => $UNI,
        'kadro' => $kadro,
        'alan' => $alanlar,
        'cetvel' => $cetvel,
        'notlar' => $notlar,
        'sart' => Kalip::ve($kadroAd, array_values([
            Kalip::toplam($toplam, $donem),
            ...$cocuklar,
            $dilBeyani,
        ])),
    ];

    if ($birim !== null) {
        $kayit['birim'] = $birim;
    }

    return $kayit;
};

$yayinKumesi = 'Makale, kitap ve bildiri kalemlerinizden';
$sanatKumesi = 'Güzel sanatlar, sanat-tasarım ve tiyatro etkinliği kalemlerinizden';
$cKumesi = 'Tez danışmanlığı, proje, patent, ödül, ders ve idari görev kalemlerinizden';

$drNotu = $baglayiciDegil.' '.$yenidenAtanma;
$docNotu = $baglayiciDegil.' '.$tezFiltresi;

return [
    // ══════════ DOKTOR ÖĞRETİM ÜYESİ (Madde 10) ══════════
    $esik('dr-saglik-muh', 'dr_ogr_uyesi', 'Dr. Öğr. Üyesi', ['saglik', 'muhendislik'],
        'munzur-2025', 100, null,
        [Kalip::puanDan("{$yayinKumesi} en az 50 puan", ['A1A2A3A4B2'], 50, madde: 'Madde 10/2')],
        'Madde 10: tüm maddelerden toplam 100 puan; A1, A2, A3, A4 ve B2 kapsamında en az 50 puan.',
        $drNotu),
    $esik('dr-fen', 'dr_ogr_uyesi', 'Dr. Öğr. Üyesi', ['fen', 'ziraat'],
        'munzur-2025', 100, null,
        [Kalip::puanDan("{$yayinKumesi} en az 50 puan", ['A1A2A3A4B2'], 50, madde: 'Madde 10/2-c')],
        'Madde 10: Fen Bilimleri (Fen ve Su Ürünleri Fakülteleri) — toplam 100 puan; A1, A2, A3, '
        .'A4 ve B2 kapsamında en az 50 puan.',
        'Munzur Fen Bilimleri alanına Su Ürünleri Fakültesini de dâhil ediyor (Madde 4/c). '.$drNotu),
    $esik('dr-sosyal', 'dr_ogr_uyesi', 'Dr. Öğr. Üyesi', ['sosyal', 'filoloji', 'egitim', 'spor'],
        'munzur-2025-sosyal', 100, null,
        [
            Kalip::puanDan('Hakemli dergilerdeki makale ve bildiri kalemlerinizden en az 20 puan',
                ['A2A3A4B2'], 20, madde: 'Madde 10/2-ç'),
            Kalip::puanDan("{$yayinKumesi} toplam en az 75 puan", ['A1A2A3B1B2'], 75,
                madde: 'Madde 10/2-ç'),
        ],
        'Madde 10/2-ç: toplam 100 puan; hakemli dergilerden en az 20 puan olmak üzere A1, A2, A3 '
        .'ile B1, B2 kapsamından toplam 75 puan.',
        'Munzur\'un Sosyal Bilimler tanımı Spor Bilimlerini, Eğitim Bilimlerini, İletişimi ve '
        .'Edebiyatı da kapsıyor (Madde 4/ç). Bu alanlarda SCI, SSCI ve AHCI makalelerinizin '
        .'puanı 1,5 KATI hesaplanıyor. '.$drNotu),
    $esik('dr-mimarlik', 'dr_ogr_uyesi', 'Dr. Öğr. Üyesi', ['mimarlik'],
        'munzur-2025', 75, null,
        [Kalip::puanDan("{$yayinKumesi} en az 30 puan", ['MIMARLIK'], 30, madde: 'Madde 10/2-d')],
        'Madde 10/2-d: toplam 75 puan; A1, A2, A3, A4 ile B1, B2, B3 kapsamında en az 30 puan.',
        'Mimarlık ve Güzel Sanatlar alanlarında toplam baraj 100 değil 75. '.$drNotu),
    $esik('dr-guzel-sanatlar', 'dr_ogr_uyesi', 'Dr. Öğr. Üyesi', ['guzel_sanatlar'],
        'munzur-2025', 75, null,
        [
            Kalip::puanDan('Yayın ve proje kalemlerinizden en az 40 puan', ['GS-DR'], 40,
                madde: 'Madde 10/2-e.1'),
            Kalip::puanDan("{$sanatKumesi} toplam en az 30 puan", ['EFH'], 30,
                madde: 'Madde 10/2-e.2'),
        ],
        'Madde 10/2-e: toplam 75 puan; yayın ve proje kalemlerinden 40, sanat etkinliklerinden '
        .'(E, F, H) 30 puan.',
        'Mimarlık ve Güzel Sanatlar alanlarında toplam baraj 100 değil 75. Sanat koşulu ulusal '
        .'veya uluslararası kişisel sergi ya da tiyatro etkinliklerinden sağlanabiliyor. '.$drNotu),

    // ══════════ DOÇENT (Madde 11) ══════════
    $esik('docentlik-saglik', 'docentlik', 'Doçent', ['saglik'],
        'munzur-2025-a1-30', 400, $DOKTORA,
        [
            Kalip::puanDan("{$yayinKumesi} doktora sonrasında en az 100 puan", ['A1A2A3A4B2'], 100,
                $DOKTORA, madde: 'Madde 11/3-a.1'),
            Kalip::puanDan("{$cKumesi} en az 40 puan", ['C'], 40, madde: 'Madde 11/3-a.2'),
            $docentlikBeyani,
        ],
        'Madde 11: doktora sonrası toplam 400 puan; A1-A4 ve B2 kapsamında 100 puan (A1\'den en '
        .'fazla 30); C kapsamında 40 puan.',
        $docNotu),
    $esik('docentlik-muh', 'docentlik', 'Doçent', ['muhendislik'],
        'munzur-2025-a1-30', 400, $DOKTORA,
        [
            Kalip::puanDan("{$yayinKumesi} doktora sonrasında en az 200 puan", ['A1A2A3A4B2'], 200,
                $DOKTORA, madde: 'Madde 11/3-b.1'),
            Kalip::puanDan("{$cKumesi} en az 60 puan", ['C'], 60, madde: 'Madde 11/3-b.2'),
            $docentlikBeyani,
        ],
        'Madde 11: doktora sonrası toplam 400 puan; A1-A4 ve B2 kapsamında 200 puan (A1\'den en '
        .'fazla 30); C kapsamında 60 puan.',
        $docNotu),
    $esik('docentlik-fen', 'docentlik', 'Doçent', ['fen', 'ziraat'],
        'munzur-2025-a1-30', 400, $DOKTORA,
        [
            Kalip::puanDan("{$yayinKumesi} doktora sonrasında en az 200 puan", ['A1A2A3A4B2'], 200,
                $DOKTORA, madde: 'Madde 11/3-c.1'),
            Kalip::puanDan("{$cKumesi} en az 60 puan", ['C'], 60, madde: 'Madde 11/3-c.2'),
            $docentlikBeyani,
        ],
        'Madde 11: doktora sonrası toplam 400 puan; A1-A4 ve B2 kapsamında 200 puan (A1\'den en '
        .'fazla 30); C kapsamında 60 puan (Matematik ve İstatistik dışındaki alanlar).',
        $docNotu, 'Matematik ve İstatistik dışındaki bölümler'),
    $esik('docentlik-fen-mat', 'docentlik', 'Doçent', ['fen'],
        'munzur-2025-a1-30', 400, $DOKTORA,
        [
            Kalip::puanDan("{$yayinKumesi} doktora sonrasında en az 200 puan", ['A1A2A3A4B2'], 200,
                $DOKTORA, madde: 'Madde 11/3-c.1'),
            $docentlikBeyani,
        ],
        'Madde 11/3-c.2 C koşulunu "Matematik ve istatistik dışındaki bilim alanlarında" diye '
        .'sınırlıyor; bu iki alt alanda C barajı YOK.',
        'Matematik ve İstatistik bölümlerinde C kapsamı (tez danışmanlığı, proje, patent, ödül, '
        .'ders, idari görev) için ayrı bir baraj YOK; yalnız toplam puan ve yayın barajı '
        .'geçerli. '.$docNotu, 'Matematik ve İstatistik'),
    $esik('docentlik-sosyal', 'docentlik', 'Doçent', ['sosyal', 'filoloji', 'egitim', 'spor'],
        'munzur-2025-sosyal-a1-30', 400, $DOKTORA,
        [
            Kalip::puanDan("{$yayinKumesi} doktora sonrasında en az 150 puan", ['A1A2A3A4B2'], 150,
                $DOKTORA, madde: 'Madde 11/3-ç.1'),
            Kalip::puanDan("{$cKumesi} doktora sonrasında en az 30 puan", ['C'], 30, $DOKTORA,
                madde: 'Madde 11/3-ç.2'),
            $docentlikBeyani,
        ],
        'Madde 11: doktora sonrası toplam 400 puan; A1-A4 ve B2 kapsamında 150 puan (A1\'den en '
        .'fazla 30); doktora sonrası C kapsamında 30 puan.',
        'Bu alanlarda SCI, SSCI ve AHCI makalelerinizin puanı 1,5 KATI hesaplanıyor. '.$docNotu),
    $esik('docentlik-mimarlik', 'docentlik', 'Doçent', ['mimarlik'],
        'munzur-2025-a1-30', 250, $DOKTORA,
        [
            Kalip::puanDan("{$yayinKumesi} en az 120 puan", ['MIMARLIK'], 120,
                madde: 'Madde 11/3-d.1'),
            $docentlikBeyani,
        ],
        'Madde 11: doktora sonrası toplam 250 puan; A1-A4 ile B1-B3 kapsamında 120 puan '
        .'(A1\'den en fazla 30). Mimarlıkta C barajı yok.',
        'Mimarlık ve Güzel Sanatlar alanlarında toplam baraj 400 değil 250. '.$docNotu),
    $esik('docentlik-guzel-sanatlar', 'docentlik', 'Doçent', ['guzel_sanatlar'],
        'munzur-2025-a1-20', 250, $DOKTORA,
        [
            Kalip::puanDan('Yayın ve proje kalemlerinizden en az 80 puan', ['GS-DOC'], 80,
                madde: 'Madde 11/3-e.1'),
            Kalip::puanDan("{$sanatKumesi} toplam en az 50 puan", ['EFH'], 50,
                madde: 'Madde 11/3-e.2'),
            $docentlikBeyani,
        ],
        'Madde 11: doktora sonrası toplam 250 puan; yayın ve proje kalemlerinden 80 puan '
        .'(A1\'den en fazla 20); sanat etkinliklerinden (E, F, H) 50 puan.',
        'Güzel Sanatlarda uluslararası kitap tavanı 30 değil 20. '.$docNotu),

    // ══════════ PROFESÖR (Madde 12) ══════════
    $esik('profesorluk-saglik', 'profesorluk', 'Profesör', ['saglik'],
        'munzur-2025-a1-50', 450, null,
        [
            Kalip::puanDan("{$yayinKumesi} doçentliğinizden sonra en az 150 puan",
                ['A1A2A3A4B2'], 150, $DOCENTLIK, madde: 'Madde 12/3-a.1'),
            Kalip::puanDan("{$cKumesi} doçentliğinizden sonra en az 50 puan", ['C'], 50,
                $DOCENTLIK, madde: 'Madde 12/3-a.2'),
            $profesorlukBeyani,
        ],
        'Madde 12: toplam 450 puan; doçentlik sonrası A1-A4 ve B2 kapsamında 150 puan (A1\'den '
        .'en fazla 50); doçentlik sonrası C kapsamında 50 puan.',
        $docNotu),
    $esik('profesorluk-muh', 'profesorluk', 'Profesör', ['muhendislik'],
        'munzur-2025-a1-50', 450, null,
        [
            Kalip::puanDan("{$yayinKumesi} doçentliğinizden sonra en az 250 puan",
                ['A1A2A3A4B2'], 250, $DOCENTLIK, madde: 'Madde 12/3-b.1'),
            Kalip::puanDan("{$cKumesi} doçentliğinizden sonra en az 70 puan", ['C'], 70,
                $DOCENTLIK, madde: 'Madde 12/3-b.2'),
            $profesorlukBeyani,
        ],
        'Madde 12: toplam 450 puan; doçentlik sonrası A1-A4 ve B2 kapsamında 250 puan (A1\'den '
        .'en fazla 50); doçentlik sonrası C kapsamında 70 puan.',
        $docNotu),
    $esik('profesorluk-fen', 'profesorluk', 'Profesör', ['fen', 'ziraat'],
        'munzur-2025-a1-50', 450, null,
        [
            Kalip::puanDan("{$yayinKumesi} doçentliğinizden sonra en az 250 puan",
                ['A1A2A3A4B2'], 250, $DOCENTLIK, madde: 'Madde 12/3-c.1'),
            Kalip::puanDan("{$cKumesi} doçentliğinizden sonra en az 70 puan", ['C'], 70,
                $DOCENTLIK, madde: 'Madde 12/3-c.2'),
            $profesorlukBeyani,
        ],
        'Madde 12: toplam 450 puan; doçentlik sonrası A1-A4 ve B2 kapsamında 250 puan (A1\'den '
        .'en fazla 50); doçentlik sonrası C kapsamında 70 puan (Matematik ve İstatistik '
        .'dışındaki alanlar).',
        $docNotu, 'Matematik ve İstatistik dışındaki bölümler'),
    $esik('profesorluk-fen-mat', 'profesorluk', 'Profesör', ['fen'],
        'munzur-2025-a1-50', 450, null,
        [
            Kalip::puanDan("{$yayinKumesi} doçentliğinizden sonra en az 250 puan",
                ['A1A2A3A4B2'], 250, $DOCENTLIK, madde: 'Madde 12/3-c.1'),
            $profesorlukBeyani,
        ],
        'Madde 12/3-c.2 C koşulunu "Matematik ve istatistik dışındaki bilim alanlarında" diye '
        .'sınırlıyor; bu iki alt alanda C barajı YOK.',
        'Matematik ve İstatistik bölümlerinde C kapsamı için ayrı bir baraj YOK. '.$docNotu,
        'Matematik ve İstatistik'),
    $esik('profesorluk-sosyal', 'profesorluk', 'Profesör', ['sosyal', 'filoloji', 'egitim', 'spor'],
        'munzur-2025-sosyal-a1-50', 450, null,
        [
            Kalip::puanDan("{$yayinKumesi} doçentliğinizden sonra en az 200 puan",
                ['A1A2A3A4B2'], 200, $DOCENTLIK, madde: 'Madde 12/3-ç.1'),
            Kalip::puanDan("{$cKumesi} doçentliğinizden sonra en az 70 puan", ['C'], 70,
                $DOCENTLIK, madde: 'Madde 12/3-ç.2'),
            $profesorlukBeyani,
        ],
        'Madde 12: toplam 450 puan; doçentlik sonrası A1-A4 ve B2 kapsamında 200 puan (A1\'den '
        .'en fazla 50); doçentlik sonrası C kapsamında 70 puan.',
        'Bu alanlarda SCI, SSCI ve AHCI makalelerinizin puanı 1,5 KATI hesaplanıyor. '.$docNotu),
    $esik('profesorluk-mimarlik', 'profesorluk', 'Profesör', ['mimarlik'],
        'munzur-2025-a1-50', 350, null,
        [
            Kalip::puanDan("{$yayinKumesi} doçentliğinizden sonra en az 200 puan",
                ['MIMARLIK'], 200, $DOCENTLIK, madde: 'Madde 12/3-d.1'),
            $profesorlukBeyani,
        ],
        'Madde 12: toplam 350 puan; doçentlik sonrası A1-A4 ile B1-B3 kapsamında 200 puan '
        .'(A1\'den en fazla 50). Mimarlıkta C barajı yok.',
        'Mimarlık ve Güzel Sanatlar alanlarında toplam baraj 450 değil 350. '.$docNotu),
    $esik('profesorluk-guzel-sanatlar', 'profesorluk', 'Profesör', ['guzel_sanatlar'],
        'munzur-2025-a1-30', 350, null,
        [
            Kalip::puanDan('Yayın ve proje kalemlerinizden doçentliğinizden sonra en az 150 puan',
                ['GS-DOC'], 150, $DOCENTLIK, madde: 'Madde 12/3-e.1'),
            Kalip::puanDan("{$sanatKumesi} toplam en az 50 puan", ['EFH'], 50,
                madde: 'Madde 12/3-e.2'),
            $profesorlukBeyani,
        ],
        'Madde 12: toplam 350 puan; doçentlik sonrası yayın ve proje kalemlerinden 150 puan '
        .'(A1\'den en fazla 30); sanat etkinliklerinden (E, F, H) 50 puan.',
        'Güzel Sanatlarda uluslararası kitap tavanı 50 değil 30. '.$docNotu),
];
