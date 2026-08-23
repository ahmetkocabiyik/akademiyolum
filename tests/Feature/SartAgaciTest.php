<?php

use App\Enums\Kategori;
use App\Enums\TemelAlan;
use App\Models\Faaliyet;
use App\Models\User;
use App\Services\Scoring\Sart\Durum;
use App\Services\Scoring\Sart\Kalip;
use App\Services\Scoring\Sart\MaddeKatalogu;
use App\Services\Scoring\Sart\Profil;
use App\Services\Scoring\Sart\ProfilCozucu;
use App\Services\Scoring\Sart\SartDeposu;
use App\Services\Scoring\Sart\SartSonucu;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;

/**
 * Kaydedilmemiş faaliyet (motor veritabanına dokunmaz).
 */
function sartFaaliyet(
    string $kaynak,
    Kategori $kategori = Kategori::Makale,
    ?string $yazarRolu = 'tek',
    ?string $tarih = null,
): Faaliyet {
    return new Faaliyet([
        'kategori' => $kategori,
        'tur' => 'Test',
        'baslik' => 'Test',
        'kaynak' => $kaynak,
        'rol' => $yazarRolu,
        'tarih' => $tarih,
        'durum' => 'onaylandi',
    ]);
}

function sartDepo(): SartDeposu
{
    return new SartDeposu;
}

/**
 * Sabancı kriterleri PROGRAMA göre yazılmış; aynı (kadro, alan) için birden çok
 * eşik var. Program belirtilmeden `bul()` bilinçli olarak null döner.
 */
const SU_CS = 'MDBF — Bilgisayar Bilimleri ve Mühendisliği Programı';

/**
 * Ağaçtaki belirli bir düğümü bulur. Aranan parça açıklamada ya da yönergenin
 * kendi madde atfında geçebilir; madde atfı sabit olduğu için açıklama metni
 * sadeleştiğinde testi kırmayan tutamak odur.
 */
function sartDugum(SartSonucu $sonuc, string $parca): SartSonucu
{
    $bulunan = $sonuc->topla(
        fn (SartSonucu $d) => str_contains($d->aciklama, $parca)
            || str_contains($d->madde ?? '', $parca),
    );

    expect($bulunan)->not->toBeEmpty("Düğüm bulunamadı: {$parca}");

    return $bulunan[0];
}

// ─────────────────────────────────────────────────────────────────────────────
// Veri bütünlüğü
// ─────────────────────────────────────────────────────────────────────────────

test('her eşiğin anahtarı tekildir', function () {
    $anahtarlar = array_column(sartDepo()->esikler(), 'anahtar');

    expect(array_diff_assoc($anahtarlar, array_unique($anahtarlar)))->toBe([]);
});

test('alan adları TemelAlan enum değerleridir', function () {
    $gecerli = array_column(TemelAlan::cases(), 'value');

    $gecersiz = collect(sartDepo()->esikler())
        ->reject(fn (array $e) => in_array($e['alan'], $gecerli, true))
        ->map(fn (array $e) => "{$e['anahtar']}: {$e['alan']}")
        ->all();

    expect($gecersiz)->toBe([]);
});

test('her eşiğin cetveli tanımlıdır', function () {
    $cetveller = array_keys(sartDepo()->cetveller());

    $eksik = collect(sartDepo()->esikler())
        ->reject(fn (array $e) => in_array($e['cetvel'], $cetveller, true))
        ->map(fn (array $e) => "{$e['anahtar']}: {$e['cetvel']}")
        ->all();

    expect($eksik)->toBe([]);
});

test('ağaçtaki her madde deseni en az bir maddeye çözülür', function () {
    // Yazım hatası olan bir desen sessizce boş kümeye çözülür ve koşul asla
    // sağlanamaz hâle gelir; bu test o sınıf hatayı yakalar.
    $depo = sartDepo();
    $hatalar = [];

    $gez = function (array $dugum, string $yol, $katalog) use (&$gez, &$hatalar) {
        foreach (['maddeler', 'oran_payda'] as $alan) {
            if (isset($dugum[$alan]) && $katalog->coz($dugum[$alan]) === []) {
                $hatalar[] = $yol.' → '.$alan.': '.implode(',', $dugum[$alan]);
            }
        }

        foreach ($dugum['cocuklar'] ?? [] as $i => $cocuk) {
            $gez($cocuk, "{$yol}/{$i}", $katalog);
        }

        if (isset($dugum['telafi'])) {
            $gez($dugum['telafi'], "{$yol}>telafi", $katalog);
        }
    };

    foreach ($depo->esikler() as $esik) {
        $gez($esik['sart'], $esik['anahtar'], $depo->katalog($esik['cetvel']));
    }

    expect($hatalar)->toBe([]);
});

test('üç üniversitenin tamamı 12 temel alan × 3 kadro için tanımlı', function () {
    $depo = sartDepo();

    foreach (['Akdeniz Üniversitesi', 'Afyon Kocatepe Üniversitesi', 'Atatürk Üniversitesi'] as $universite) {
        foreach (['dr_ogr_uyesi', 'docentlik', 'profesorluk'] as $kadro) {
            foreach (TemelAlan::cases() as $alan) {
                expect($depo->bul($universite, $kadro, $alan->value))
                    ->not->toBeNull("{$universite} · {$kadro} · {$alan->value}");
            }
        }
    }
});

// ─────────────────────────────────────────────────────────────────────────────
// Motor — temel davranış
// ─────────────────────────────────────────────────────────────────────────────

test('Akdeniz Grup 1 Dr. Öğr. Üyesi: üç makale ve YDS ile sağlanır', function () {
    $depo = sartDepo();
    $esik = $depo->bul('Akdeniz Üniversitesi', 'dr_ogr_uyesi', 'fen');

    // Üçü de son beş yılda, ikisinde başlıca yazar (tek yazarlı → başlıca sayılır).
    $sonuc = $depo->degerlendir($esik, [
        sartFaaliyet('SCIE/SSCI (Q3)', tarih: '2024-01-10'),   // 1.4 → 90
        sartFaaliyet('SCIE/SSCI (Q3)', tarih: '2024-06-20'),   // 90
        sartFaaliyet('SCIE/SSCI (Q3)', tarih: '2025-02-05'),   // 90
    ], new Profil(yds: 75));

    // Tez yayını koşulu belge ile beyan edildiği için kök belirsiz kalır;
    // ölçülebilir koşulların tamamı sağlanmış olmalı.
    expect($sonuc->eksikler())->toBe([])
        ->and(sartDugum($sonuc, 'toplam en az 100 puan')->mevcut)->toBe(270)
        ->and(sartDugum($sonuc, 'Son beş yılda en az 3 yayın')->mevcut)->toBe(3)
        ->and(sartDugum($sonuc, 'En az 2 makalede başlıca yazar')->mevcut)->toBe(3);
});

test('YDS girilmemişse koşul sağlanmadı değil BELİRSİZ olur', function () {
    $depo = sartDepo();
    $esik = $depo->bul('Akdeniz Üniversitesi', 'dr_ogr_uyesi', 'fen');

    $sonuc = $depo->degerlendir($esik, [
        sartFaaliyet('SCIE/SSCI (Q3)'),
        sartFaaliyet('SCIE/SSCI (Q3)'),
        sartFaaliyet('SCIE/SSCI (Q3)'),
    ], new Profil);

    // YDS ve "son beş yıl" koşulu (faaliyetlerin tarihi yok) belirsiz kalır.
    expect(sartDugum($sonuc, 'yabancı dil')->durum)->toBe(Durum::Belirsiz)
        ->and($sonuc->durum)->toBe(Durum::Belirsiz)
        ->and($sonuc->belirsizler())->toHaveCount(2);
});

test('bir eser puanını en yüksek maddeden alır, Faaliyet->puan alanına bakılmaz', function () {
    $depo = sartDepo();
    $esik = $depo->bul('Akdeniz Üniversitesi', 'dr_ogr_uyesi', 'fen');

    // puan alanı kasten yanlış: motor cetvelden hesaplamalı (Q1 → 1.2 → 300).
    $yanlisPuanli = sartFaaliyet('SCIE/SSCI (Q1)');
    $yanlisPuanli->puan = 9999;

    $sonuc = $depo->degerlendir($esik, [$yanlisPuanli], new Profil(yds: 70));

    expect(sartDugum($sonuc, 'toplam en az 100 puan')->mevcut)->toBe(300);
});

// ─────────────────────────────────────────────────────────────────────────────
// Eski şemanın taşıyamadığı koşullar
// ─────────────────────────────────────────────────────────────────────────────

test('oransal koşul: "puanın en az yarısı makalelerden" gerçekten hesaplanır', function () {
    $depo = sartDepo();
    $esik = $depo->bul('Akdeniz Üniversitesi', 'dr_ogr_uyesi', 'sosyal');

    // Makale 15 (TR-Dizin), kitap 4 × 30 = 120 → toplam 135, yarısı 68 > 15.
    $sonuc = $depo->degerlendir($esik, [
        sartFaaliyet('TR Dizin'),
        sartFaaliyet('Uluslararası/Ulusal Kitap', Kategori::Kitap),
        sartFaaliyet('Uluslararası/Ulusal Kitap', Kategori::Kitap),
        sartFaaliyet('Uluslararası/Ulusal Kitap', Kategori::Kitap),
        sartFaaliyet('Uluslararası/Ulusal Kitap', Kategori::Kitap),
    ], new Profil(yds: 70));

    $oran = sartDugum($sonuc, 'en az yarısı bilimsel makalelerden');

    expect($oran->durum)->toBe(Durum::Saglanmadi)
        ->and($oran->mevcut)->toBe(15)
        ->and($oran->gerekli)->toBe(68);
});

test('Güzel Sanatlar %40 oranı Hukuk/İlahiyat %50 oranından ayrı kayıttır', function () {
    $depo = sartDepo();

    $gs = $depo->bul('Akdeniz Üniversitesi', 'dr_ogr_uyesi', 'guzel_sanatlar');
    $hukuk = $depo->bul('Akdeniz Üniversitesi', 'dr_ogr_uyesi', 'hukuk');

    $faaliyetler = [
        sartFaaliyet('TR Dizin'),                                   // makale 15
        sartFaaliyet('Uluslararası/Ulusal Kitap', Kategori::Kitap), // 30
    ];

    // Toplam 45 → %40 = 18, %50 = 23. Oranların FARKLI hesaplandığını doğruluyoruz.
    $gsOran = sartDugum($depo->degerlendir($gs, $faaliyetler, new Profil(yds: 70)), 'en az %40');
    $hukukOran = sartDugum($depo->degerlendir($hukuk, $faaliyetler, new Profil(yds: 70)), 'en az yarısı');

    expect($gsOran->gerekli)->toBe(18)
        ->and($hukukOran->gerekli)->toBe(23);
});

test('telafi: Afyon TR Dizin şartı uluslararası makaleyle karşılanabilir', function () {
    $depo = sartDepo();
    $esik = $depo->bul('Afyon Kocatepe Üniversitesi', 'dr_ogr_uyesi', 'saglik');

    // TR Dizin makalesi yok; ama 3 Q1 makale var → dipnot telafisi devreye girer.
    $sonuc = $depo->degerlendir($esik, [
        sartFaaliyet('SCIE/SSCI (Q1)'),
        sartFaaliyet('SCIE/SSCI (Q1)'),
        sartFaaliyet('SCIE/SSCI (Q1)'),
    ], new Profil);

    $trDugum = sartDugum($sonuc, 'TR Dizin kapsamında en az 1 makale');

    expect($trDugum->mevcut)->toBe(0)
        ->and($trDugum->telafiIleSaglandi())->toBeTrue()
        ->and($sonuc->durum)->toBe(Durum::Saglandi);
});

test('Atatürk indeks alt sınırı artık hesaplanıyor (eski şemada "bilgi" idi)', function () {
    $depo = sartDepo();
    $esik = $depo->bul('Atatürk Üniversitesi', 'dr_ogr_uyesi', 'sosyal');

    // 1 × Q3 (02.01.03 → 16) + 3 × TR Dizin (02.02.01 → 6) = makale 34, indeks 16.
    $sonuc = $depo->degerlendir($esik, [
        sartFaaliyet('SCIE/SSCI (Q3)'),
        sartFaaliyet('TR Dizin'),
        sartFaaliyet('TR Dizin'),
        sartFaaliyet('TR Dizin'),
    ], new Profil(yds: 70));

    expect(sartDugum($sonuc, 'Makalelerden en az 30 puan')->durum)->toBe(Durum::Saglandi)
        ->and(sartDugum($sonuc, 'en az 12 puanı')->durum)->toBe(Durum::Saglandi)
        ->and(sartDugum($sonuc, 'en az 12 puanı')->mevcut)->toBe(16);
});

test('Atatürk Hukuk indeks alt sınırı 5, diğer B grubu alanlarında 12', function () {
    $depo = sartDepo();

    $faaliyetler = [sartFaaliyet('ESCI / Scopus'), sartFaaliyet('TR Dizin')]; // indeks 8

    $hukuk = $depo->degerlendir(
        $depo->bul('Atatürk Üniversitesi', 'dr_ogr_uyesi', 'hukuk'), $faaliyetler, new Profil(yds: 70)
    );
    $sosyal = $depo->degerlendir(
        $depo->bul('Atatürk Üniversitesi', 'dr_ogr_uyesi', 'sosyal'), $faaliyetler, new Profil(yds: 70)
    );

    expect(sartDugum($hukuk, 'en az 5 puanı')->durum)->toBe(Durum::Saglandi)
        ->and(sartDugum($sosyal, 'en az 12 puanı')->durum)->toBe(Durum::Saglanmadi);
});

// ─────────────────────────────────────────────────────────────────────────────
// Dönem ekseni — motorun eksik veriyle yanlış cevap vermemesi
// ─────────────────────────────────────────────────────────────────────────────

test('tarihi girilmemiş faaliyet dönem koşulunu BELİRSİZ yapar, sağlanmadı değil', function () {
    $depo = sartDepo();
    $esik = $depo->bul('Akdeniz Üniversitesi', 'profesorluk', 'fen');

    $sonuc = $depo->degerlendir($esik, [
        sartFaaliyet('SCIE/SSCI (Q1)', yazarRolu: 'baslica'),
        sartFaaliyet('SCIE/SSCI (Q1)', yazarRolu: 'baslica'),
    ], new Profil(docentlikTarihi: Carbon::parse('2020-01-01'), yds: 70));

    $hedef = sartDugum($sonuc, 'Doçentlik sonrası en az 2 makalede başlıca yazar');

    expect($hedef->durum)->toBe(Durum::Belirsiz)
        ->and($hedef->belirsizlikNedeni)->toContain('tarihi girilmemiş');
});

test('dönem koşulu tarihler girilince kesin sonuç verir', function () {
    $depo = sartDepo();
    $esik = $depo->bul('Akdeniz Üniversitesi', 'profesorluk', 'fen');
    $profil = new Profil(docentlikTarihi: Carbon::parse('2020-01-01'), yds: 70);

    $sonrasi = $depo->degerlendir($esik, [
        sartFaaliyet('SCIE/SSCI (Q1)', yazarRolu: 'baslica', tarih: '2022-05-01'),
        sartFaaliyet('SCIE/SSCI (Q1)', yazarRolu: 'baslica', tarih: '2023-05-01'),
    ], $profil);

    $oncesi = $depo->degerlendir($esik, [
        sartFaaliyet('SCIE/SSCI (Q1)', yazarRolu: 'baslica', tarih: '2018-05-01'),
        sartFaaliyet('SCIE/SSCI (Q1)', yazarRolu: 'baslica', tarih: '2019-05-01'),
    ], $profil);

    $ad = 'Doçentlik sonrası en az 2 makalede başlıca yazar';

    expect(sartDugum($sonrasi, $ad)->durum)->toBe(Durum::Saglandi)
        ->and(sartDugum($oncesi, $ad)->durum)->toBe(Durum::Saglanmadi);
});

test('yazarlık rolü filtresi: ortak yazarlı makale "başlıca yazar" koşulunu karşılamaz', function () {
    $depo = sartDepo();
    $esik = $depo->bul('Akdeniz Üniversitesi', 'dr_ogr_uyesi', 'sosyal');

    $sonuc = $depo->degerlendir($esik, [
        sartFaaliyet('SCIE/SSCI (Q1)', yazarRolu: 'ortak'),
        sartFaaliyet('SCIE/SSCI (Q1)', yazarRolu: 'ortak'),
    ], new Profil(yds: 70));

    expect(sartDugum($sonuc, 'En az 1 makalede başlıca yazar')->durum)->toBe(Durum::Saglanmadi);
});

// ─────────────────────────────────────────────────────────────────────────────
// Kleene mantığı
// ─────────────────────────────────────────────────────────────────────────────

test('veya düğümü: bir dal kesin sağlanıyorsa diğerinin belirsizliği sonucu bozmaz', function () {
    $depo = sartDepo();
    $esik = $depo->bul('Afyon Kocatepe Üniversitesi', 'dr_ogr_uyesi', 'hukuk');

    // İkinci seçenek (TR Dizin ×4) kesin sağlanıyor.
    $sonuc = $depo->degerlendir($esik, [
        sartFaaliyet('TR Dizin'),
        sartFaaliyet('TR Dizin'),
        sartFaaliyet('TR Dizin'),
        sartFaaliyet('TR Dizin'),
        sartFaaliyet('SCIE/SSCI (Q1)'),
    ], new Profil);

    expect(sartDugum($sonuc, 'Üç seçenekten biri')->durum)->toBe(Durum::Saglandi);
});

test('beyan düğümü kökü belirsiz yapar ama sağlanmadı yapmaz', function () {
    $depo = sartDepo();
    $esik = $depo->bul('Afyon Kocatepe Üniversitesi', 'dr_ogr_uyesi', 'guzel_sanatlar');

    $sonuc = $depo->degerlendir($esik, [
        sartFaaliyet('SCIE/SSCI (Q1)'),
        sartFaaliyet('SCIE/SSCI (Q1)'),
        sartFaaliyet('SCIE/SSCI (Q1)'),
    ], new Profil);

    expect($sonuc->durum)->toBe(Durum::Belirsiz)
        ->and($sonuc->beyanlar())->toHaveCount(1)
        ->and($sonuc->eksikler())->toBe([]);
});

// ─────────────────────────────────────────────────────────────────────────────
// Faaliyetten türeyen ölçütler (atıf / proje / tez danışmanlığı)
// ─────────────────────────────────────────────────────────────────────────────

test('proje yürütücülüğü koşulu Faaliyetler\'e eklenen proje kaydıyla karşılanır', function () {
    $depo = sartDepo();
    $esik = $depo->bul('Akdeniz Üniversitesi', 'docentlik', 'fen');
    $kullanici = new User(['yds_puani' => 75]);
    $kullanici->docentlik_tarihi = Carbon::parse('2020-01-01');

    $temel = [
        sartFaaliyet('SCIE/SSCI (Q1)', yazarRolu: 'baslica', tarih: '2022-01-01'),
        sartFaaliyet('SCIE/SSCI (Q1)', yazarRolu: 'baslica', tarih: '2023-01-01'),
    ];

    // Proje kaydı yokken: koşul belirsiz (profilde değer yok, faaliyet de yok).
    $projesiz = $depo->degerlendir($esik, $temel, $kullanici->sartProfili($temel));
    expect(sartDugum($projesiz, 'projede en az 1 yürütücülük')->durum)->toBe(Durum::Belirsiz);

    // Yürütücü rolüyle proje eklenince kesinleşir.
    $ile = array_merge($temel, [
        new Faaliyet([
            'kategori' => Kategori::Proje, 'tur' => 'Proje', 'baslik' => 'TÜBİTAK 1001',
            'kaynak' => 'TÜBİTAK', 'rol' => 'yurutucu', 'durum' => 'onaylandi',
        ]),
    ]);
    $projeli = $depo->degerlendir($esik, $ile, $kullanici->sartProfili($ile));

    expect(sartDugum($projeli, 'projede en az 1 yürütücülük')->durum)->toBe(Durum::Saglandi)
        ->and(sartDugum($projeli, 'projede en az 1 yürütücülük')->mevcut)->toBe(1);

    // Sadece araştırmacı rolüyle eklenirse yürütücülük koşulu KESİN olumsuz olur.
    $arastirmaci = array_merge($temel, [
        new Faaliyet([
            'kategori' => Kategori::Proje, 'tur' => 'Proje', 'baslik' => 'AB projesi',
            'kaynak' => 'AB Çerçeve / Ufuk', 'rol' => 'arastirmaci', 'durum' => 'onaylandi',
        ]),
    ]);
    $sonuc = $depo->degerlendir($esik, $arastirmaci, $kullanici->sartProfili($arastirmaci));

    expect(sartDugum($sonuc, 'projede en az 1 yürütücülük')->durum)->toBe(Durum::Saglanmadi);
});

test('proje puanı fon kaynağı ve role göre cetvelden gelir', function () {
    $katalog = sartDepo()->katalog('akdeniz-2026');
    $kodlar = $katalog->coz(['BOLUM_6_PROJE']);

    $proje = fn (string $kaynak, string $rol) => new Faaliyet([
        'kategori' => Kategori::Proje, 'tur' => 'Proje', 'baslik' => 'x',
        'kaynak' => $kaynak, 'rol' => $rol, 'durum' => 'onaylandi',
    ]);

    // Akdeniz Ek-1: 6.1 uluslararası yürütücü 200 · 6.2 araştırıcı 50
    //               6.3 ulusal yürütücü 50    · 6.4 araştırmacı 15
    //               6.5 BAP yürütücü 20       · 6.6 araştırıcı 5
    expect($katalog->puan($proje('AB Çerçeve / Ufuk', 'yurutucu'), $kodlar))->toBe(200)
        ->and($katalog->puan($proje('AB Çerçeve / Ufuk', 'arastirmaci'), $kodlar))->toBe(50)
        ->and($katalog->puan($proje('TÜBİTAK', 'yurutucu'), $kodlar))->toBe(50)
        ->and($katalog->puan($proje('TÜBİTAK', 'arastirmaci'), $kodlar))->toBe(15)
        ->and($katalog->puan($proje('BAP (Üniversite)', 'yurutucu'), $kodlar))->toBe(20)
        ->and($katalog->puan($proje('BAP (Üniversite)', 'arastirmaci'), $kodlar))->toBe(5);
});

test('atıf ve bildiri kayıtları toplam puana katkı verir', function () {
    $depo = sartDepo();
    $esik = $depo->bul('Akdeniz Üniversitesi', 'dr_ogr_uyesi', 'fen');
    $profil = new Profil(yds: 75);

    $yalnizMakale = [sartFaaliyet('TR Dizin')]; // 1.8 → 15
    $atifli = array_merge($yalnizMakale, [
        sartFaaliyet('WoS / Scopus', Kategori::Atif),                        // 3.1 → 5
        sartFaaliyet('Uluslararası Tam Metin (CPCI)', Kategori::Bildiri),    // 7.1 → 8
    ]);

    expect(sartDugum($depo->degerlendir($esik, $yalnizMakale, $profil), 'toplam en az 100 puan')->mevcut)->toBe(15)
        ->and(sartDugum($depo->degerlendir($esik, $atifli, $profil), 'toplam en az 100 puan')->mevcut)->toBe(28);
});

// ─────────────────────────────────────────────────────────────────────────────
// Yeni arketipler
// ─────────────────────────────────────────────────────────────────────────────

test('kendine referans veren grup tanımı motoru kilitlemez', function () {
    // 'A3' => ['A3'] gibi bir veri hatası özyinelemeyi sonsuza sokuyordu.
    $katalog = new MaddeKatalogu(
        anahtar: 'test',
        maddeler: ['A1' => ['baslik' => 'x'], 'A3' => ['baslik' => 'y']],
        gruplar: ['A3' => ['A3'], 'DONGU' => ['DIGER'], 'DIGER' => ['DONGU', 'A1']],
    );

    expect($katalog->coz(['A3']))->toBe(['A3'])
        ->and($katalog->coz(['DONGU']))->toBe(['A1']);
});

test('Gümüşhane: grup bazlı asgari puanlar cetvelden hesaplanır', function () {
    $depo = sartDepo();
    $esik = $depo->bul('Gümüşhane Üniversitesi', 'dr_ogr_uyesi', 'sosyal');

    expect($esik)->not->toBeNull();

    // A1a Q1 = 35 · B4a uluslararası tam metin = 6 · B8a ulusal tam metin = 5
    $sonuc = $depo->degerlendir($esik, [
        sartFaaliyet('SCIE/SSCI (Q1)'),
        sartFaaliyet('TR Dizin'),                                              // A3 = 10
        sartFaaliyet('Uluslararası Tam Metin', Kategori::Bildiri),             // B4a = 6
        sartFaaliyet('Ulusal Tam Metin', Kategori::Bildiri),                   // B8a = 5
    ], new Profil);

    expect(sartDugum($sonuc, 'TABLO-3 · A. Makale')->mevcut)->toBe(45)
        ->and(sartDugum($sonuc, 'TABLO-3 · B. Bildiri')->mevcut)->toBe(11)
        ->and(sartDugum($sonuc, 'toplam en az 55 puan')->mevcut)->toBe(56)
        ->and($sonuc->durum)->toBe(Durum::Saglandi);
});

test('Gümüşhane dipnot (1): makale puanı A1-A2\'den karşılanırsa A3 şartı düşer', function () {
    $depo = sartDepo();
    $esik = $depo->bul('Gümüşhane Üniversitesi', 'dr_ogr_uyesi', 'hukuk');

    // Tek Q1 makale (35P) — A3'ten hiç yayın yok ama makale barajı A1'den doluyor.
    $sonuc = $depo->degerlendir($esik, [
        sartFaaliyet('SCIE/SSCI (Q1)'),
        sartFaaliyet('Uluslararası Tam Metin', Kategori::Bildiri),
        sartFaaliyet('Ulusal Tam Metin', Kategori::Bildiri),
    ], new Profil);

    $a3 = sartDugum($sonuc, 'TR Dizin dergisinde en az 1 makale');

    expect($a3->mevcut)->toBe(0)
        ->and($a3->telafiIleSaglandi())->toBeTrue()
        // Sayaç 0/1 kalır ama koşul karşılandığı için ilerleme tamdır; aksi
        // hâlde arayüz sağlanmış koşulu %0 dolulukla (yeşil ama boş) çizer.
        ->and($a3->oran())->toBe(100);
});

test('Samsun: puansız yönergede toplam düğümü yoktur, şartlar adetle çözülür', function () {
    $depo = sartDepo();
    $esik = $depo->bul('Samsun Üniversitesi', 'dr_ogr_uyesi', 'sosyal');

    expect($esik)->not->toBeNull()
        // Puan barajı yok → arayüz baraj 0 gösterir.
        ->and($depo->degerlendir($esik, [], new Profil)->rolile('toplam'))->toBeNull();

    $sonuc = $depo->degerlendir($esik, [
        sartFaaliyet('SCIE/SSCI (Q1)'),   // A1
        sartFaaliyet('TR Dizin'),         // A3
        sartFaaliyet('Ulusal Tam Metin', Kategori::Bildiri), // C2
    ], new Profil);

    expect(sartDugum($sonuc, 'Tür A1/A2/A3')->mevcut)->toBe(2)
        ->and(sartDugum($sonuc, 'Başlıca yazar olduğunuz toplam en az 3 çalışma')->mevcut)->toBe(3)
        ->and($sonuc->durum)->toBe(Durum::Saglandi);
});

test('Samsun doçentlik: beş alternatiften biri yeterli', function () {
    $depo = sartDepo();
    $esik = $depo->bul('Samsun Üniversitesi', 'docentlik', 'ilahiyat');
    $profil = new Profil(doktoraTarihi: Carbon::parse('2018-01-01'));

    // (e) şıkkı: D1/D3/D5 türü 2 proje, biri doçentlik sonrası — burada yok.
    // (a) şıkkı: doktora sonrası 4 adet A1.
    $dortA1 = array_map(
        fn () => sartFaaliyet('SCIE/SSCI (Q1)', tarih: '2021-01-01'),
        range(1, 4),
    );

    expect($depo->degerlendir($esik, $dortA1, $profil)->durum)->toBe(Durum::Saglandi)
        // Üç tane yetmez ve başka şık da dolmuyor.
        ->and($depo->degerlendir($esik, array_slice($dortA1, 0, 3), $profil)->durum)->toBe(Durum::Saglanmadi);
});

test('Bursa Uludağ: adet koşullu alanlar hesaplanır, puana bağlı olanlar belirsiz kalır', function () {
    $depo = sartDepo();
    $profil = new Profil(yds: 75, programDili: 'turkce');
    $makale = sartFaaliyet('SCIE/SSCI (Q1)');

    // İlahiyat: [A] saf adet koşulu → kesin sonuç.
    $ilahiyat = $depo->degerlendir(
        $depo->bul('Bursa Uludağ Üniversitesi', 'dr_ogr_uyesi', 'ilahiyat'), [$makale], $profil,
    );

    // Fen: [A] tamamen puana bağlı → ÜAK cetvelinden hesaplanır.
    // Tek Q1 makalesi 30 puan: ne 50'lik alt koşulu ne 90'lık toplamı karşılar.
    $fen = $depo->degerlendir(
        $depo->bul('Bursa Uludağ Üniversitesi', 'dr_ogr_uyesi', 'fen'), [$makale], $profil,
    );

    expect($ilahiyat->durum)->toBe(Durum::Saglandi)
        ->and($fen->durum)->toBe(Durum::Saglanmadi)
        // Artık beyan değil, ölçülen bir eksik.
        ->and($fen->beyanlar())->toBe([])
        ->and(sartDugum($fen, 'Tablo-1 · [A]')->mevcut)->toBe(30)
        ->and(sartDugum($fen, 'Tablo-1 · [A]')->gerekli)->toBe(50);
});

test('Bursa Uludağ: ÜAK cetveline bağlı puan koşulu gerçekten hesaplanır', function () {
    $depo = sartDepo();
    $esik = $depo->bul('Bursa Uludağ Üniversitesi', 'dr_ogr_uyesi', 'muhendislik');

    // 2 × Q1 (30) = 60 → alt koşul (50) tamam. Toplam 90 için 30 puan daha:
    // BKCI kitap 20 + TÜBİTAK yürütücülük 15 = 95.
    $sonuc = $depo->degerlendir($esik, [
        sartFaaliyet('SCIE/SSCI (Q1)', yazarRolu: 'baslica'),
        sartFaaliyet('SCIE/SSCI (Q1)'),
        sartFaaliyet('BKCI / Scopus Kitap', Kategori::Kitap),
        sartFaaliyet('TÜBİTAK', Kategori::Proje, 'yurutucu'),
    ], new Profil(yds: 75, programDili: 'turkce'));

    expect(sartDugum($sonuc, 'Tablo-1 · [A]')->mevcut)->toBe(75)  // 60 makale + 15 proje
        ->and(sartDugum($sonuc, 'toplam en az 90 puan')->mevcut)->toBe(95)
        ->and($sonuc->durum)->toBe(Durum::Saglandi);
});

test('Bursa Uludağ: [A] sağlanmazsa [C] telafisi belirsizlik üretir, ret değil', function () {
    $depo = sartDepo();
    $esik = $depo->bul('Bursa Uludağ Üniversitesi', 'dr_ogr_uyesi', 'hukuk');

    // Q1-Q3 makalesi yok → [A] düşer, [C] puana bağlı olduğu için karara bağlanamaz.
    $sonuc = $depo->degerlendir($esik, [
        sartFaaliyet('TR Dizin'),
    ], new Profil(yds: 75, programDili: 'turkce'));

    $a = sartDugum($sonuc, 'Tablo-1 · [A]');

    // TR Dizin makalesi 10 puan: [C] telafisi de (50/90) karşılanmıyor.
    expect($a->mevcut)->toBe(0)
        ->and($a->telafi)->not->toBeNull()
        ->and($a->durum)->toBe(Durum::Saglanmadi)
        ->and($sonuc->durum)->toBe(Durum::Saglanmadi);
});

test('referans düğümü {alan} yer tutucusunu çözer', function () {
    $depo = sartDepo();
    $esik = $depo->bul('Bursa Uludağ Üniversitesi', 'profesorluk', 'ilahiyat');
    $sonuc = $depo->degerlendir($esik, [sartFaaliyet('SCIE/SSCI (Q1)')], new Profil(yds: 75, programDili: 'turkce'));

    // Hedef eşik çözülemeseydi "bulunamadı" gerekçesiyle çocuksuz belirsiz dönerdi.
    expect($sonuc->cocuklar)->toHaveCount(1)
        ->and($sonuc->belirsizler())->not->toContain(
            fn ($d) => str_contains($d->belirsizlikNedeni ?? '', 'bulunamadı'),
        );
});

test('telafi ilişkisi VE değil VEYA: ana koşul düşse de telafi belirsizse kesin ret verilmez', function () {
    // Regresyon: `Durum::ve` kullanıldığında ana=Saglanmadi + telafi=Belirsiz
    // kombinasyonu kesin RET üretiyordu. Doğrusu Belirsiz.
    $depo = new SartDeposu(
        esikVerisi: [[
            'anahtar' => 't', 'universite' => 'T', 'kadro' => 'dr_ogr_uyesi', 'alan' => 'sosyal',
            'birim' => null, 'cetvel' => 'test-cetvel', 'notlar' => '',
            'sart' => Kalip::adet('Ana koşul', ['M1'], 1)
                + ['telafi' => Kalip::beyan('Belge ile doğrulanacak alternatif')],
        ]],
        cetvelVerisi: ['test-cetvel' => ['maddeler' => [
            'M1' => ['baslik' => 'Q1', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)']],
        ]]],
    );

    $sonuc = $depo->degerlendir($depo->esik('t'), [], new Profil);

    expect($sonuc->durum)->toBe(Durum::Belirsiz)
        ->and($sonuc->eksikler())->toBe([]);
});

test('cetveli girilmemiş koşul, belge ile beyan edilecek koşuldan ayrılır', function () {
    // Sentetik veri: üretimdeki "cetvel eksik" düğümleri kapatıldıkça bu test
    // veriye bağlı kalırsa kendiliğinden anlamsızlaşır. Sınanan şey mekanizma.
    $depo = new SartDeposu(
        esikVerisi: [[
            'anahtar' => 'x-dr-fen', 'universite' => 'X Üni', 'kadro' => 'dr_ogr_uyesi',
            'alan' => 'fen', 'birim' => null, 'cetvel' => 'x', 'notlar' => '',
            'sart' => Kalip::ve('Şartlar', [
                Kalip::hesaplanamiyor('Dış ölçeğe göre en az 100 puan', 'md. 3'),
                Kalip::beyan('Jüri kararıyla belirlenir'),
            ]),
        ]],
        cetvelVerisi: ['x' => ['maddeler' => []]],
    );

    $sonuc = $depo->degerlendir($depo->esik('x-dr-fen'), [], new Profil);

    // İkisi de beyandır ama biri BİZİM veri açığımız, diğeri kalıcı gerçeklik.
    expect($sonuc->beyanlar())->toHaveCount(2)
        ->and($sonuc->hesaplanamayanlar())->toHaveCount(1)
        ->and($sonuc->hesaplanamayanlar()[0]->aciklama)->toBe('Dış ölçeğe göre en az 100 puan')
        // Eksik bilgi sayılmamalı: adayın girmesi gereken bir veri yok.
        ->and($sonuc->belirsizler())->toBe([])
        // Adaya gösterilen metin bizim veri girişi durumumuzu anlatmamalı.
        ->and($sonuc->hesaplanamayanlar()[0]->aciklama)->not->toContain('projeye');
});

test('grup tavanı uygulanır: tek kategoriden gelen puan barajı sahte biçimde aşamaz', function () {
    $katalog = new MaddeKatalogu(
        anahtar: 'test',
        maddeler: [
            'M1' => ['baslik' => 'Q1 makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'puan' => 30],
            'B1' => ['baslik' => 'Bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Ulusal Tam Metin'], 'puan' => 5],
        ],
        gruplar: ['B' => ['B1']],
        grupTavanlari: ['B' => 10],
    );

    $faaliyetler = collect([
        sartFaaliyet('SCIE/SSCI (Q1)'),
        ...array_fill(0, 6, sartFaaliyet('Ulusal Tam Metin', Kategori::Bildiri)),
    ]);

    // Tavansız toplam 30 + 6×5 = 60 olurdu; bildiri tavanı 10 → 40.
    expect($katalog->topla($faaliyetler, ['M1', 'B1']))->toBe(40)
        ->and($katalog->topla($faaliyetler, ['B1']))->toBe(10);
});

test('tavan dolarken yüksek puanlı faaliyet önceliklidir', function () {
    $katalog = new MaddeKatalogu(
        anahtar: 'test',
        maddeler: [
            'K1' => ['baslik' => 'BKCI kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 20],
            'K2' => ['baslik' => 'Kitap bölümü', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 3],
        ],
        gruplar: ['K' => ['K1', 'K2']],
        grupTavanlari: ['K' => 20],
    );

    // Sıralama olmasaydı önce 3'ler girip tavanı düşük değerle doldurabilirdi.
    expect($katalog->topla(collect([
        sartFaaliyet('Kitap Bölümü', Kategori::Kitap),
        sartFaaliyet('BKCI / Scopus Kitap', Kategori::Kitap),
    ]), ['K1', 'K2']))->toBe(20);
});

test('dışlama koşulu faaliyetin tez ilişkisi alanından okunur', function () {
    $depo = sartDepo();
    $esik = $depo->bul('Sabancı Üniversitesi', 'docentlik', 'muhendislik', SU_CS);
    $profil = new Profil(dersYariyil: 2, projeYurutuculuk: 2, tezDanismanlik: 3);

    $ile = fn (?string $donem) => tap(sartFaaliyet('SCIE/SSCI (Q1)'), fn ($f) => $f->donem = $donem);
    $ad = 'doktora tezinden üretilmemiş';
    $degerlendir = fn (array $f) => sartDugum($depo->degerlendir($esik, $f, $profil), $ad);

    // Girilmemişse karara bağlanamaz — "sağlanmadı" değil.
    expect($degerlendir(array_map(fn () => $ile(null), range(1, 8)))->durum)->toBe(Durum::Belirsiz);

    // Üçü tezden bağımsız → sağlanır.
    $saglanan = $degerlendir([
        $ile('tez_disi'), $ile('tez_disi'), $ile('tez_disi'),
        $ile('doktora'), $ile('doktora'), $ile('doktora'), $ile('doktora'), $ile('doktora'),
    ]);
    expect($saglanan->durum)->toBe(Durum::Saglandi)
        ->and($saglanan->mevcut)->toBe(3);

    // Hepsi doktora tezinden → kesin olumsuz.
    expect($degerlendir(array_map(fn () => $ile('doktora'), range(1, 8)))->mevcut)->toBe(0);

    // Yönergenin dediği "DOKTORA tezinden üretilmemiş": yüksek lisans tezinden
    // üretilmiş yayın bu koşula SAYILIR. Düzey ayrımı olmasaydı haksız yere
    // dışlanır ve koşul sağlanmamış görünürdü.
    $yl = $degerlendir([
        $ile('yuksek_lisans'), $ile('yuksek_lisans'), $ile('yuksek_lisans'),
        $ile('doktora'), $ile('doktora'), $ile('doktora'), $ile('doktora'), $ile('doktora'),
    ]);
    expect($yl->durum)->toBe(Durum::Saglandi)
        ->and($yl->mevcut)->toBe(3);

    // Eski kayıtlarda düzey yok: doktora varsayılmaz, belirsiz kalır.
    expect($degerlendir(array_map(fn () => $ile('tezden'), range(1, 8)))->durum)->toBe(Durum::Belirsiz);
});

test('faaliyetten türetilen ölçüt eksikse profil değil Faaliyetler bölümü işaret edilir', function () {
    $profil = new Profil;

    expect($profil->eksikNedeni('ders_yariyil'))->toContain('Faaliyetler')
        ->and($profil->eksikNedeni('tez_danismanlik'))->toContain('Faaliyetler')
        ->and($profil->eksikNedeni('proje_yurutuculuk'))->toContain('Faaliyetler')
        ->and($profil->eksikNedeni('atif_sayisi'))->toContain('Faaliyetler')
        // Tek skaler olanlar gerçekten profilden okunur.
        ->and($profil->eksikNedeni('yds'))->toContain('Profil')
        ->and($profil->eksikNedeni('h_indeksi'))->toContain('Profil');

    // Motor bu gerekçeyi düğüme taşıyor mu?
    $depo = sartDepo();
    $sonuc = $depo->degerlendir(
        $depo->bul('Sabancı Üniversitesi', 'docentlik', 'muhendislik', SU_CS), [], $profil,
    );

    expect(sartDugum($sonuc, 'ders vermiş olmak')->belirsizlikNedeni)
        ->toContain('Faaliyetler bölümüne henüz ders');
});

test('ders ve tez danışmanlığı kaydı yoksa 0 kabul edilir, koşul kesin sonuca bağlanır', function () {
    $cozucu = new ProfilCozucu;
    $user = User::factory()->onboarded()->create();

    // Ders, boş kategoriyi kesin 0 sayan TEK ölçüt.
    $profil = $cozucu->coz($user, []);

    expect($profil->dersYariyil)->toBe(0)
        ->and($profil->tezDanismanlik)->toBe(0)
        // Atıf ve proje ölçütlerinde boşluk belirsizlik üretmeye devam etmeli.
        ->and($profil->atifSayisi)->toBeNull()
        ->and($profil->projeYurutuculuk)->toBeNull();

    $depo = sartDepo();
    $sonuc = $depo->degerlendir(
        $depo->bul('Sabancı Üniversitesi', 'docentlik', 'muhendislik', SU_CS), [], $profil,
    );

    $ders = sartDugum($sonuc, 'ders vermiş olmak');

    expect($ders->mevcut)->toBe(0)
        ->and($ders->gerekli)->toBe(1)
        ->and($ders->durum)->toBe(Durum::Saglanmadi);
})->uses(RefreshDatabase::class);

test('tez danışmanlığı sayımı: baş danışmanlık sayılır, eş danışmanlık 2:1 denklikle girer', function () {
    $depo = sartDepo();
    $esik = $depo->bul('Sabancı Üniversitesi', 'docentlik', 'muhendislik', SU_CS);
    $ad = 'Bitmiş en az 3 lisansüstü tezde baş danışmanlık';

    $bas = fn () => sartFaaliyet('Doktora Tezi', Kategori::TezDanismanligi, 'danisman');
    $es = fn () => sartFaaliyet('Yüksek Lisans Tezi', Kategori::TezDanismanligi, 'es_danisman');

    $cozucu = new ProfilCozucu;
    $user = User::factory()->onboarded()->create();
    $degerlendir = fn (array $f) => $depo->degerlendir($esik, $f, $cozucu->coz($user, $f));

    // Yalnızca eş danışmanlık: baş danışmanlık sayısına doğrudan eklenmez.
    // 4 eş danışmanlık var ama denklik en fazla 1 tez için kullanılabilir.
    expect(sartDugum($degerlendir([$es(), $es(), $es(), $es()]), $ad)->mevcut)->toBe(1);

    // 2 baş + 2 eş = 2 + (2÷2, azami 1) = 3 → sağlanır.
    $karma = $degerlendir([$bas(), $bas(), $es(), $es()]);
    expect(sartDugum($karma, $ad)->mevcut)->toBe(3)
        ->and(sartDugum($karma, $ad)->durum)->toBe(Durum::Saglandi)
        // Sayaç sebepsiz artmış görünmesin: uygulanan denklik arayüze taşınır.
        ->and(sartDugum($karma, $ad)->donusumler)->toBe([
            '2 eş danışmanlık 1 baş danışmanlığa denk (en fazla 1 tez için)',
        ]);

    // Denklik gerekmiyorsa listelenmez.
    expect(sartDugum($degerlendir([$bas(), $bas(), $bas()]), $ad)->donusumler)->toBe([]);

    // 3 baş danışmanlık tek başına yeter.
    expect(sartDugum($degerlendir([$bas(), $bas(), $bas()]), $ad)->durum)->toBe(Durum::Saglandi);

    // Tez izleme jürisi baş danışmanlık değildir.
    $juri = $degerlendir([sartFaaliyet('Tez İzleme / Jüri Üyeliği', Kategori::TezDanismanligi, 'danisman')]);
    expect(sartDugum($juri, $ad)->mevcut)->toBe(0);
})->uses(RefreshDatabase::class);

test('belge beyanı eksik bilgi sayılmaz', function () {
    $depo = sartDepo();
    $profil = new Profil(dersYariyil: 2, projeYurutuculuk: 2, tezDanismanlik: 3);

    $sonuc = $depo->degerlendir(
        $depo->bul('Sabancı Üniversitesi', 'docentlik', 'muhendislik', SU_CS),
        array_map(fn () => tap(sartFaaliyet('SCIE/SSCI (Q1)'), fn ($f) => $f->donem = 'tez_disi'), range(1, 8)),
        $profil,
    );

    // "Projelerden en az biri tamamlanmış olmalı" bir beyandır: eksik veri yok,
    // koşul doğası gereği otomatik doğrulanamıyor. Aday "bir şey girmeyi
    // unuttum" sanmamalı.
    expect($sonuc->beyanlar())->toHaveCount(1)
        ->and($sonuc->belirsizler())->toBe([])
        ->and($sonuc->hesaplanamayanlar())->toBe([]);
});

test('şart ağacındaki her dışlama etiketi motorda tanımlıdır', function () {
    // Tanınmayan etiket sessizce null döner: koşul hiçbir veriyle kesinleşmez.
    // Bu test o sınıf yazım hatasını yakalar.
    $depo = sartDepo();
    $ornek = new Faaliyet(['kategori' => Kategori::Makale, 'donem' => 'doktora']);
    $bilinmeyen = [];

    $gez = function (array $dugum, string $yol) use (&$gez, &$bilinmeyen, $ornek) {
        foreach ($dugum['haric'] ?? [] as $etiket) {
            if ($ornek->haricDegeri($etiket) === null) {
                $bilinmeyen[] = "{$yol}: {$etiket}";
            }
        }

        foreach ($dugum['cocuklar'] ?? [] as $i => $cocuk) {
            $gez($cocuk, "{$yol}/{$i}");
        }

        if (isset($dugum['telafi'])) {
            $gez($dugum['telafi'], "{$yol}>telafi");
        }
    };

    foreach ($depo->esikler() as $esik) {
        $gez($esik['sart'], $esik['anahtar']);
    }

    expect($bilinmeyen)->toBe([]);
});

test('tek koşullu yönergede kökün kendisi koşul olarak listelenir', function () {
    $depo = sartDepo();

    // Sabancı Dr. Öğr. Üyesi'nin tek şartı var: ağacın kökü birleştirici değil
    // yaprak. Arayüz koşulları `cocuklar` üzerinden listeleseydi kart boş
    // görünür, "bu kadro için şart yok" sanılırdı.
    $tek = $depo->degerlendir(
        $depo->bul('Sabancı Üniversitesi', 'dr_ogr_uyesi', 'muhendislik', SU_CS), [], new Profil,
    );

    expect($tek->cocuklar)->toBe([])
        ->and($tek->kosullar())->toHaveCount(1)
        ->and($tek->kosullar()[0]->aciklama)->toContain('en az 3 bilimsel makale');

    // Çok koşullu ağaçta davranış değişmez.
    $cok = $depo->degerlendir(
        $depo->bul('Sabancı Üniversitesi', 'docentlik', 'muhendislik', SU_CS), [], new Profil,
    );

    expect($cok->kosullar())->toBe($cok->cocuklar)
        ->and($cok->kosullar())->toHaveCount(6);
});

test('eşleşme oranı ağacın mantığına uyar: VEYA dalında sağlanmayan alternatif eksiklik sayılmaz', function () {
    $depo = sartDepo();
    $profil = new Profil(doktoraTarihi: Carbon::parse('2020-01-01'));

    $makale = fn () => sartFaaliyet('SCIE/SSCI (Q1)', tarih: '2024-01-01');

    // Samsun Doçent beş alternatifli bir VEYA: 1. yol (A1 türü 4 çalışma) tam
    // sağlanıyor, diğer dördü sağlanmıyor. Oran yaprakların minimumu alınırsa
    // %0 çıkar ve "Başvuru Yapılabilir" rozetli üniversite sıralamada sona düşer.
    $sonuc = $depo->degerlendir(
        $depo->bul('Samsun Üniversitesi', 'docentlik', 'sosyal'),
        [$makale(), $makale(), $makale(), $makale()],
        $profil,
    );

    expect($sonuc->durum)->toBe(Durum::Saglandi)
        ->and($sonuc->oran())->toBe(100);

    // Hiçbir yol sağlanmıyorsa oran en iyi alternatiften okunur, sıfırdan değil.
    $kismi = $depo->degerlendir(
        $depo->bul('Samsun Üniversitesi', 'docentlik', 'sosyal'),
        [$makale(), $makale()],
        $profil,
    );

    // En iyi alternatif 2. yol: "en az 2'si A1" tam (%100), "toplamda 6" 2/6
    // (%33) → ortalama %67. 1. yol yalnızca 2/4 = %50 verirdi.
    expect($kismi->durum)->toBe(Durum::Saglanmadi)
        ->and($kismi->oran())->toBe(67);
});

test('dönem belirsizliğinde hangi verinin eksik olduğu ayrı ayrı söylenir', function () {
    $depo = sartDepo();
    $esik = $depo->bul('Sabancı Üniversitesi', 'profesorluk', 'muhendislik', SU_CS);
    $ad = 'doçentlik sonrası';

    $makale = fn (?string $tarih) => sartFaaliyet('SCIE/SSCI (Q1)', tarih: $tarih);
    $bul = fn (array $f, Profil $p) => sartDugum($depo->degerlendir($esik, $f, $p), $ad)->belirsizlikNedeni;

    // İkisi de eksik → ikisi de söylenmeli.
    expect($bul([$makale(null)], new Profil))
        ->toContain('doçentlik tarihi')
        ->toContain('faaliyetlerin tarihi');

    // Faaliyet tarihleri tamam, profil eksik → yalnızca profil suçlanmalı.
    // Eskiden mesaj hep faaliyeti işaret ediyordu; aday tarihleri doldurup
    // koşulun hâlâ belirsiz kalmasıyla karşılaşıyordu.
    expect($bul([$makale('2024-06-01')], new Profil))
        ->toContain('doçentlik tarihi')
        ->not->toContain('faaliyetlerin tarihi');

    // Profil tamam, bazı faaliyetlerin tarihi yok → yalnızca faaliyet.
    $profil = new Profil(docentlikTarihi: Carbon::parse('2022-01-01'));

    expect($bul([$makale('2024-06-01'), $makale(null)], $profil))
        ->toContain('faaliyetlerin tarihi')
        ->not->toContain('doçentlik tarihi');
});

test('ilk atanma koşulu geçmiş bir atamaya dayanamaz', function () {
    // Dr. Öğr. Üyesi İLK atanmada "son atamadan bu yana" koşulu mantıksızdır;
    // o referans yalnızca yeniden atanma kadrosunda anlamlıdır.
    //
    // DİKKAT: "docentlik kadrosu docentlik referansı kullanamaz" gibi bir kural
    // YOKTUR. Türkiye'de doçentlik UNVANI (ÜAK verir) ile doçent KADROSU
    // (üniversite verir) ayrı şeylerdir; kadroya başvuran aday unvanı çoktan
    // almıştır. Samsun bunu birebir böyle yazıyor: "En az 1 tanesi doçentlik
    // sonrası olmak şartıyla ... Doçent Kadrosu İçin Asgari Şartlar".
    $hatalar = [];

    $gez = function (array $dugum, string $yol) use (&$gez, &$hatalar) {
        if (($dugum['donem']['baslangic'] ?? null) === 'son_atama') {
            $hatalar[] = $yol;
        }

        foreach ($dugum['cocuklar'] ?? [] as $i => $cocuk) {
            $gez($cocuk, "{$yol}/{$i}");
        }

        if (isset($dugum['telafi'])) {
            $gez($dugum['telafi'], "{$yol}>telafi");
        }
    };

    foreach (sartDepo()->esikler() as $esik) {
        if (! str_ends_with($esik['kadro'], '_yeniden')) {
            $gez($esik['sart'], $esik['anahtar']);
        }
    }

    expect($hatalar)->toBe([]);
});

test('Atatürk AR-GE koşulu: yürütücülük puanı yetmezse Q1/Q2 yayınlarla tamamlanır', function () {
    $depo = sartDepo();
    $esik = $depo->bul('Atatürk Üniversitesi', 'docentlik', 'fen');
    $ad = 'Yürütücü olduğunuz projelerden en az 30 puan';

    $tubitak = fn () => sartFaaliyet('TÜBİTAK', Kategori::Proje, 'yurutucu');   // 02.04.04 → 20
    $q1 = fn () => sartFaaliyet('SCIE/SSCI (Q1)');                              // 02.01.01 → 60

    // Tek TÜBİTAK yürütücülüğü 20 puan: 30'u karşılamıyor.
    $eksik = sartDugum($depo->degerlendir($esik, [$tubitak()], new Profil), $ad);
    expect($eksik->mevcut)->toBe(20)
        ->and($eksik->durum)->toBe(Durum::Saglanmadi);

    // Yönerge md. 5: en az bir yürütücülük varsa kalan Q1/Q2 yayınlardan tamamlanır.
    $telafili = sartDugum($depo->degerlendir($esik, [$tubitak(), $q1()], new Profil), $ad);
    expect($telafili->durum)->toBe(Durum::Saglandi)
        ->and($telafili->telafiIleSaglandi())->toBeTrue();

    // İki yürütücülük tek başına yeter; telafiye gerek kalmaz.
    $dogrudan = sartDugum($depo->degerlendir($esik, [$tubitak(), $tubitak()], new Profil), $ad);
    expect($dogrudan->mevcut)->toBe(40)
        ->and($dogrudan->telafiIleSaglandi())->toBeFalse();
});

test('Sabancı program bazlı: aynı alanda program seçimi eşiği değiştirir', function () {
    $depo = sartDepo();
    $emf = 'MDBF — Endüstri Mühendisliği / Matematik / Fizik Programları';

    // Aynı kadro ve temel alan, farklı program → farklı tez danışmanlığı eşiği.
    $cs = $depo->bul('Sabancı Üniversitesi', 'docentlik', 'muhendislik', SU_CS);
    $endustri = $depo->bul('Sabancı Üniversitesi', 'docentlik', 'muhendislik', $emf);

    expect($cs['anahtar'])->toBe('sabanci-docent-mdbf-cs-muhendislik')
        ->and($endustri['anahtar'])->toBe('sabanci-docent-mdbf-emf-muhendislik');

    $profil = new Profil(dersYariyil: 2, projeYurutuculuk: 2, tezDanismanlik: 2);
    $ad = 'lisansüstü tezde baş danışmanlık';

    // CS 3 tez ister, Endüstri/Matematik/Fizik 2 — aynı adayda farklı sonuç.
    expect(sartDugum($depo->degerlendir($cs, [], $profil), $ad)->gerekli)->toBe(3)
        ->and(sartDugum($depo->degerlendir($endustri, [], $profil), $ad)->gerekli)->toBe(2);

    // Program seçilmemişse hangi kriterin geçerli olduğu bilinemez.
    expect($depo->bul('Sabancı Üniversitesi', 'docentlik', 'muhendislik'))->toBeNull();
});

test('Sabancı araştırma ağırlıklı yol: dokuz başarıdan beşi k_ile ile sınanır', function () {
    $depo = sartDepo();
    $esik = $depo->bul('Sabancı Üniversitesi', 'profesorluk', 'muhendislik',
        'MDBF Tüm Programlar — Araştırma ve Uygulama Ağırlıklı');

    $sonuc = $depo->degerlendir($esik, [], new Profil);
    $besBasari = sartDugum($sonuc, 'dokuz başarıdan en az beşini');

    // Dokuz seçenek, beşi gerekli; hepsi beyan olduğu için karar belirsiz kalır
    // ve aday "sağlanmadı" damgası yemez.
    expect($besBasari->cocuklar)->toHaveCount(9)
        ->and($besBasari->gerekli)->toBe(5)
        ->and($besBasari->durum)->toBe(Durum::Belirsiz);

    // Aynı kadroda eğitim-araştırma yolu çok daha düşük yayın eşiği istiyor.
    $egitimYolu = $depo->bul('Sabancı Üniversitesi', 'profesorluk', 'muhendislik', SU_CS);

    expect(sartDugum($depo->degerlendir($egitimYolu, [], new Profil), 'en az 16 makale')->gerekli)->toBe(16)
        ->and(sartDugum($sonuc, 'en az 27 bilimsel makale')->gerekli)->toBe(27);
});

test('SSBF kitap eşdeğerlikleri CERES kategorisine göre farklı ağırlık taşır', function () {
    $depo = sartDepo();
    $esik = $depo->bul('Sabancı Üniversitesi', 'docentlik', 'sosyal',
        'SSBF — Ekonomi / Siyaset Bilimi / Psikoloji Programları');
    $ad = 'en az 5 bilimsel makale';

    $makale = fn () => sartFaaliyet('SCIE/SSCI (Q2)');
    $kitapA = fn () => sartFaaliyet('BKCI / Scopus Kitap', Kategori::Kitap);   // CERES A → 3 makale
    $kitapB = fn () => sartFaaliyet('Uluslararası/Ulusal Kitap', Kategori::Kitap); // CERES B → 2 makale

    // 2 makale + CERES A kitap = 2 + 3 = 5.
    $a = sartDugum($depo->degerlendir($esik, [$makale(), $makale(), $kitapA()], new Profil), $ad);
    expect($a->mevcut)->toBe(5)
        ->and($a->durum)->toBe(Durum::Saglandi);

    // Aynı sayıda kitap ama B kategori: 2 + 2 = 4, yetmiyor.
    $b = sartDugum($depo->degerlendir($esik, [$makale(), $makale(), $kitapB()], new Profil), $ad);
    expect($b->mevcut)->toBe(4)
        ->and($b->durum)->toBe(Durum::Saglanmadi);

    // SSBF çeyreklik aramıyor: Q3 makale de ana kümeye sayılır (MDBF'de sayılmazdı).
    $q3 = sartDugum($depo->degerlendir($esik, array_map(
        fn () => sartFaaliyet('SCIE/SSCI (Q3)'), range(1, 5),
    ), new Profil), $ad);
    expect($q3->mevcut)->toBe(5);
});

test('YBF danışmanlık koşulu ağırlıklı puanla ölçülür', function () {
    $depo = sartDepo();
    $esik = $depo->bul('Sabancı Üniversitesi', 'docentlik', 'sosyal', 'YBF — Yönetim Bilimleri Fakültesi');
    $ad = 'Danışmanlıklardan en az 4 puan';

    $dr = fn () => sartFaaliyet('Doktora Tezi', Kategori::TezDanismanligi, 'danisman');        // 4
    $yl = fn () => sartFaaliyet('Yüksek Lisans Tezi', Kategori::TezDanismanligi, 'danisman');  // 2

    // Tek doktora tezi 4 puan → koşul karşılanır.
    expect(sartDugum($depo->degerlendir($esik, [$dr()], new Profil), $ad)->mevcut)->toBe(4);

    // Aynı sayıda ama yüksek lisans: 2 puan, yetmiyor.
    expect(sartDugum($depo->degerlendir($esik, [$yl()], new Profil), $ad)->durum)->toBe(Durum::Saglanmadi);

    // İki yüksek lisans = 4 puan, doktora tezine denk.
    expect(sartDugum($depo->degerlendir($esik, [$yl(), $yl()], new Profil), $ad)->durum)->toBe(Durum::Saglandi);
});

test('EK-4 eğitim ağırlıklı yolda sanatsal sergi makale şartını karşılar', function () {
    $depo = sartDepo();
    $esik = $depo->bul('Sabancı Üniversitesi', 'docentlik', 'guzel_sanatlar',
        'Eğitim Ağırlıklı Kariyer Gelişim Yolu (tüm fakülteler)');
    $ad = 'en az 3 bilimsel makale';
    $profil = new Profil(docentlikTarihi: Carbon::parse('2015-01-01'));

    $bienal = fn () => sartFaaliyet('Kişisel Etkinlik (Uluslararası)', Kategori::SanatselEtkinlik,
        yazarRolu: null, tarih: '2022-05-01');
    $solo = fn () => sartFaaliyet('Kişisel Etkinlik (Ulusal)', Kategori::SanatselEtkinlik,
        yazarRolu: null, tarih: '2022-05-01');

    // Yönerge: uluslararası solo sergi / bienal = 2 solo sergi.
    // 1 bienal (2) + 1 solo (1) = 3 → makale şartı karşılanır.
    $karma = sartDugum($depo->degerlendir($esik, [$bienal(), $solo()], $profil), $ad);
    expect($karma->mevcut)->toBe(3)
        ->and($karma->durum)->toBe(Durum::Saglandi);

    // Tek solo sergi 1 sayılır, yetmez.
    expect(sartDugum($depo->degerlendir($esik, [$solo()], $profil), $ad)->durum)->toBe(Durum::Saglanmadi);

    // Giriş koşulları belge ile teyit edildiği için kök belirsiz kalır —
    // aday 10 yıl kıdemi yok diye "sağlanmadı" damgası yemez.
    $sonuc = $depo->degerlendir($esik, [$bienal(), $solo()], $profil);
    expect($sonuc->beyanlar())->not->toBeEmpty()
        ->and($sonuc->durum)->toBe(Durum::Belirsiz);
});

test('Mersin tek cetvelde üç listeyi ayrı tutar — puan listeler arası sızmaz', function () {
    $depo = sartDepo();
    $profil = new Profil(doktoraTarihi: Carbon::parse('2015-01-01'));

    // Aynı adayda hem TABLO A (makale) hem TABLO B (sergi) kalemi var.
    $faaliyetler = [
        sartFaaliyet('SCIE/SSCI (Q1)', tarih: '2020-01-01'),                         // Liste A · 2.a = 50
        sartFaaliyet('Kişisel Etkinlik (Uluslararası)', Kategori::SanatselEtkinlik,  // TABLO B · ç-1 = 30
            yazarRolu: null, tarih: '2020-01-01'),
        sartFaaliyet('Resital (Uluslararası)', Kategori::SanatselEtkinlik,           // TABLO C · 1b-1 = 40
            yazarRolu: null, tarih: '2020-01-01'),
    ];

    $baraj = function (string $alan) use ($depo, $faaliyetler, $profil): SartSonucu {
        $esik = $depo->bul('Mersin Üniversitesi', 'docentlik', $alan);

        return $depo->degerlendir($esik, $faaliyetler, $profil)->rolile('toplam');
    };

    // Sağlık/fen adayı: yalnızca Liste A sayılır, sanat kalemleri barajına girmez.
    expect($baraj('saglik')->mevcut)->toBe(50)
        ->and($baraj('saglik')->aciklama)->toContain('Liste A');

    // Güzel sanatlar: TABLO B + C sayılır, makale barajına GİRMEZ.
    expect($baraj('guzel_sanatlar')->mevcut)->toBe(70)
        ->and($baraj('guzel_sanatlar')->aciklama)->toContain('TABLO B + C');

    // Mimarlık: yönerge barajı iki listeden BİRLİKTE istiyor (md. 2.2 e-7).
    expect($baraj('mimarlik')->mevcut)->toBe(80)
        ->and($baraj('mimarlik')->aciklama)->toContain('Liste A + TABLO B');

    // Baraj düğümü kapsam rozeti taşımaz — 68 kalemlik liste okunmaz olurdu.
    expect($baraj('guzel_sanatlar')->kapsam)->toBe([]);
});

test('Sabancı tek cetvelde dört fakültenin kabul kümesini ayrı tutar', function () {
    $katalog = sartDepo()->katalog('sabanci-turler');

    // Yönergenin dört eki farklı dergi kümesi kabul ediyor. Dört blok tek
    // dosyada birleştiğinde ilk bozulacak şey budur: bir maddenin kaynak
    // etiketi komşu fakülteye sızarsa aday yanlış fakültenin ölçütüyle ölçülür.
    $kabul = fn (string $kaynak, string $grup) => $katalog->eslesir(
        sartFaaliyet($kaynak), $katalog->coz([$grup]),
    );

    // SCOPUS: SSBF ve EK-4 sayıyor, MDBF ve YBF saymıyor.
    expect($kabul('ESCI / Scopus', 'SSBF-MAKALE'))->toBeTrue()
        ->and($kabul('ESCI / Scopus', 'EGITIM-MAKALE'))->toBeTrue()
        ->and($kabul('ESCI / Scopus', 'MDBF-MAKALE'))->toBeFalse()
        ->and($kabul('ESCI / Scopus', 'YBF-MAKALE'))->toBeFalse();

    // Q3: çeyreklik şartı olmayan SSBF ve YBF sayıyor; MDBF yalnızca ikame
    // maddesinde (SU-M2), EK-4 hiç saymıyor.
    expect($kabul('SCIE/SSCI (Q3)', 'SSBF-MAKALE'))->toBeTrue()
        ->and($kabul('SCIE/SSCI (Q3)', 'YBF-MAKALE'))->toBeTrue()
        ->and($kabul('SCIE/SSCI (Q3)', 'EGITIM-MAKALE'))->toBeFalse();

    // Q1 dördünde de sayılır — ayrım kabul kümesinin ucunda, ortasında değil.
    foreach (['MDBF-MAKALE', 'SSBF-MAKALE', 'YBF-MAKALE', 'EGITIM-MAKALE'] as $grup) {
        expect($kabul('SCIE/SSCI (Q1)', $grup))->toBeTrue();
    }

    // Kod uzayları ayrık: hiçbir madde iki fakültenin grubuna birden düşmez.
    $gruplar = ['MDBF-MAKALE', 'SSBF-MAKALE', 'YBF-MAKALE', 'EGITIM-MAKALE',
        'SSBF-CERES', 'YBF-DANISMANLIK', 'EGITIM-SERGI'];
    $tum = array_merge(...array_map(fn (string $g) => $katalog->coz([$g]), $gruplar));
    expect($tum)->toHaveCount(count(array_unique($tum)));
});

test('ÜAK 12 temel alan cetveli ortak gövdeden doğru türetiliyor', function () {
    $depo = sartDepo();
    $alanlar = ['fen', 'sosyal', 'muhendislik', 'saglik', 'egitim', 'filoloji',
        'hukuk', 'ilahiyat', 'mimarlik', 'spor', 'ziraat', 'guzel_sanatlar'];

    $katalog = fn (string $alan) => $depo->katalog("uak-2024-mart-{$alan}");

    foreach ($alanlar as $alan) {
        expect($katalog($alan))->not->toBeNull("uak-2024-mart-{$alan} üretilmedi");
    }

    // Ortak gövde: 43 kalem on iki tabloda da aynı. Tek dosyaya taşınmasının
    // sebebi buydu — bir kalem bir alanda düzeltilip diğerlerinde unutulamaz.
    foreach (['1a-Q1' => 30, '1c' => 10, '4a' => 20, '2a' => 10] as $kod => $puan) {
        foreach ($alanlar as $alan) {
            expect($katalog($alan)->maddePuani($kod))->toBe($puan, "{$alan}/{$kod}");
        }
    }

    // Ayrışan sekiz kalem: ÜAK tabloları burada gerçekten farklı.
    expect($katalog('ilahiyat')->maddePuani('3d'))->toBe(5)      // diğerlerinde 8
        ->and($katalog('fen')->maddePuani('3d'))->toBe(8)
        ->and($katalog('hukuk')->maddePuani('4c'))->toBe(20)     // diğerlerinde 5
        ->and($katalog('fen')->maddePuani('4c'))->toBe(5)
        ->and($katalog('muhendislik')->maddePuani('3ı'))->toBe(5) // diğerlerinde 3
        ->and($katalog('sosyal')->maddePuani('3g'))->toBe(3);     // fen'de 5

    // 4e (tahkik) yalnız İlahiyat tablosunda var ve yalnız oradaki gruba girer.
    expect($katalog('ilahiyat')->maddePuani('4e'))->toBe(10)
        ->and($katalog('fen')->maddeler)->not->toHaveKey('4e')
        ->and($katalog('ilahiyat')->coz(['4cde']))->toContain('4e')
        ->and($katalog('fen')->coz(['4cd']))->not->toContain('4e');

    // Grup kırılımı da alana göre değişiyor: '3gh' fen/mühendislik/mimarlık/
    // ziraat tablolarında yok.
    expect($katalog('sosyal')->gruplar)->toHaveKey('3gh')
        ->and($katalog('fen')->gruplar)->not->toHaveKey('3gh');

    // Kapsam açığı alana göre farklı — notun doğru sayıyı söylemesi gerekiyor.
    expect($katalog('fen')->kapsamNotu)->toContain('en fazla 16 puan')
        ->and($katalog('sosyal')->kapsamNotu)->toContain('en fazla 26 puan')
        ->and($katalog('ilahiyat')->kapsamNotu)->toContain('en fazla 26 puan')
        ->and($katalog('spor')->kapsamNotu)->toContain('en fazla 21 puan');
});

describe('taslak eşikler adaya gösterilmez', function () {
    /** Biri doğrulanmış biri taslak, aynı üniversitenin iki ayrı alanı. */
    $depo = fn () => new SartDeposu(
        esikVerisi: [
            [
                'anahtar' => 'x-dogru', 'universite' => 'X Üniversitesi',
                'kadro' => 'docentlik', 'alan' => 'fen', 'cetvel' => 'c', 'notlar' => '',
                'sart' => Kalip::adet('Doğrulanmış koşul', ['m'], 1),
            ],
            [
                'anahtar' => 'x-taslak', 'universite' => 'X Üniversitesi',
                'kadro' => 'docentlik', 'alan' => 'sosyal', 'cetvel' => 'c', 'notlar' => '',
                'durum' => SartDeposu::TASLAK, 'birim' => 'Taslak Programı',
                'sart' => Kalip::adet('Taslak koşul', ['m'], 1),
            ],
            [
                'anahtar' => 'y-taslak', 'universite' => 'Y Üniversitesi',
                'kadro' => 'docentlik', 'alan' => 'fen', 'cetvel' => 'c', 'notlar' => '',
                'durum' => SartDeposu::TASLAK,
                'sart' => ['tip' => 'referans', 'aciklama' => 'Taslağa atıf', 'esik' => 'x-taslak'],
            ],
        ],
        cetvelVerisi: ['c' => ['maddeler' => ['m' => ['baslik' => 'M', 'kategori' => 'makale', 'puan' => 1]]]],
    );

    test('bul() taslak eşiği döndürmez', function () use ($depo) {
        expect($depo()->bul('X Üniversitesi', 'docentlik', 'fen'))->not->toBeNull()
            ->and($depo()->bul('X Üniversitesi', 'docentlik', 'sosyal'))->toBeNull();
    });

    test('yalnızca taslağı olan üniversite listede görünmez', function () use ($depo) {
        expect($depo()->universiteler())->toBe(['X Üniversitesi']);
    });

    test('taslak eşiğin birimi program seçeneği olarak sunulmaz', function () use ($depo) {
        expect($depo()->birimler('X Üniversitesi'))->toBe([]);
    });

    test('referans taslağa çözülmez — veri sızmak yerine belirsiz kalır', function () use ($depo) {
        expect($depo()->esik('x-taslak'))->toBeNull()
            ->and($depo()->esik('x-dogru'))->not->toBeNull();
    });

    test('esikler() taslakları saklamaz — kapsam raporu kuyruğu ölçebilmeli', function () use ($depo) {
        expect($depo()->esikler())->toHaveCount(3)
            ->and($depo()->dogrulanmisEsikler())->toHaveCount(1);
    });
});

test('kaynak sözlüğü yönergelerin ayırdığı kalemleri ayırt edebiliyor', function () {
    $katalog = sartDepo()->katalog('ataturk-2026');

    // Üç ödül de 30 puan ama yönerge genel "TÜBA/TÜBİTAK bilim ödülü"nü 40
    // veriyor. Hepsi tek etikete düşseydi `puan()` en yükseği aldığı için
    // her ödül 40 sayılırdı — sözlük bölünmeden bu kalemler girilemiyordu.
    $puan = fn (string $kaynak) => $katalog->puan(
        sartFaaliyet($kaynak, Kategori::Odul, yazarRolu: null), array_keys($katalog->maddeler),
    );

    expect($puan('Ufuk Avrupa / ERC Ödülü'))->toBe(30)
        ->and($puan('TÜBA GEBİP / TWAS Teşvik Ödülü'))->toBe(30)
        ->and($puan('YÖK Ödülü'))->toBe(30)
        ->and($puan('TÜBİTAK / TÜBA Ödülü'))->toBe(40);

    // İdari görevler de tek tek puanlanıyor: rektör 50, rektör yardımcısı 40.
    $idari = fn (string $kaynak) => $katalog->puan(
        sartFaaliyet($kaynak, Kategori::IdariGorev, yazarRolu: null), array_keys($katalog->maddeler),
    );

    expect($idari('Rektör'))->toBe(50)
        ->and($idari('Rektör Yardımcısı'))->toBe(40)
        ->and($idari('Bölüm Başkanı'))->toBe(10)
        ->and($idari('Bölüm Başkan Yardımcısı'))->toBe(5);
});

test('editörlük çeyrekliğe göre farklı puanlanıyor (Afyon 7.1)', function () {
    $katalog = sartDepo()->katalog('afyon-2026');
    $kodlar = array_keys($katalog->maddeler);

    $puan = fn (string $kaynak) => $katalog->puan(
        sartFaaliyet($kaynak, Kategori::Editorluk, yazarRolu: null), $kodlar,
    );

    expect($puan('WoS Dergi (Q1)'))->toBe(100)
        ->and($puan('WoS Dergi (Q4)'))->toBe(60)
        ->and($puan('TR Dizin Dergi'))->toBe(50)
        ->and($puan('Diğer Hakemli Dergi'))->toBe(20);

    // ÜAK çeyreklik gözetmiyor: dördü de aynı maddeye düşer.
    $uak = sartDepo()->katalog('uak-2024-mart-fen');
    $uakKodlar = array_keys($uak->maddeler);

    foreach (['WoS Dergi (Q1)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi'] as $kaynak) {
        expect($uak->puan(sartFaaliyet($kaynak, Kategori::Editorluk, yazarRolu: null), $uakKodlar))->toBe(2);
    }
});

test('Sabancı SSBF ve YBF araştırma ağırlıklı yolları Dr. Öğr. Üyesi kadrosunu kapsıyor', function () {
    $depo = sartDepo();

    // Bu iki kariyer yolu eksikti; SSBF/YBF'nin "Eğitim ve Araştırma Ağırlıklı"
    // yolunda yönerge Dr. Öğr. Üyesi TANIMLAMIYOR, araştırma ağırlıklı yolda
    // tanımlıyor. Eksikken sosyal ve güzel sanatlar alanlarında Dr. Öğr. Üyesi
    // adayına gösterilecek hiçbir eşik yoktu.
    $ssbf = $depo->bul('Sabancı Üniversitesi', 'dr_ogr_uyesi', 'sosyal',
        'SSBF Tüm Programlar — Araştırma ve Uygulama Ağırlıklı');
    $ybf = $depo->bul('Sabancı Üniversitesi', 'dr_ogr_uyesi', 'sosyal',
        'YBF — Araştırma ve Uygulama Ağırlıklı');

    expect($ssbf)->not->toBeNull()->and($ybf)->not->toBeNull();

    // Kabul kümeleri fakülteye göre ayrı kalmalı: SCOPUS makale SSBF'de sayılır,
    // YBF'de sayılmaz (EK-3 yalnızca SCI/SCIE/SSCI diyor).
    $profil = new Profil(doktoraTarihi: Carbon::parse('2015-01-01'));
    $scopus = fn () => sartFaaliyet('ESCI / Scopus', tarih: '2020-01-01');

    $makale = fn (array $esik) => collect($depo->degerlendir($esik, [$scopus(), $scopus()], $profil)->kosullar())
        ->first(fn (SartSonucu $k) => str_contains($k->aciklama, 'en az 2 bilimsel makale'))->mevcut;

    expect($makale($ssbf))->toBe(2)
        ->and($makale($ybf))->toBe(0);

    // Araştırma ağırlıklı yolun doçent eşiği, eğitim ağırlıklı yoldan yüksek.
    $arastirma = $depo->bul('Sabancı Üniversitesi', 'docentlik', 'sosyal', 'YBF — Araştırma ve Uygulama Ağırlıklı');
    $egitim = $depo->bul('Sabancı Üniversitesi', 'docentlik', 'sosyal', 'YBF — Yönetim Bilimleri Fakültesi');

    $gerekli = fn (array $esik) => collect($depo->degerlendir($esik, [], $profil)->kosullar())
        ->first(fn (SartSonucu $k) => str_contains($k->aciklama, 'bilimsel makale'))->gerekli;

    expect($gerekli($arastirma))->toBe(9)
        ->and($gerekli($egitim))->toBe(6);
});

test('Ege alan grubuna göre farklı yayın koşulu uyguluyor', function () {
    $depo = sartDepo();
    $profil = new Profil(doktoraTarihi: Carbon::parse('2015-01-01'));

    // Dört ESCI/Scopus makalesi: Fen'de sayılmaz (yönerge 1(a) yani
    // SCIE/SSCI/AHCI istiyor), Sosyal'de sayılır (1(a,b,c,d) kümesi geniş).
    $esci = fn () => sartFaaliyet('ESCI / Scopus', tarih: '2020-01-01');
    $faaliyetler = [$esci(), $esci(), $esci(), $esci()];

    $sayac = function (string $alan) use ($depo, $faaliyetler, $profil): SartSonucu {
        $esik = $depo->bul('Ege Üniversitesi', 'dr_ogr_uyesi', $alan);

        return collect($depo->degerlendir($esik, $faaliyetler, $profil)->kosullar())
            ->first(fn (SartSonucu $k) => str_contains($k->aciklama, 'en az'));
    };

    expect($sayac('fen')->mevcut)->toBe(0)
        ->and($sayac('sosyal')->mevcut)->toBe(4);

    // Spor Bilimlerinde eşik bir eksik: üç yayın yeterli.
    expect($sayac('spor')->gerekli)->toBe(3)
        ->and($sayac('fen')->gerekli)->toBe(4);

    // Eğitim, filoloji ve ziraat yönergede hiç anılmıyor — eşik üretilmedi.
    foreach (['egitim', 'filoloji', 'ziraat'] as $alan) {
        expect($depo->bul('Ege Üniversitesi', 'dr_ogr_uyesi', $alan))->toBeNull();
    }
});

test('Ege yurt dışı koşulu puanla telafi edilebiliyor', function () {
    $depo = sartDepo();
    $esik = $depo->bul('Ege Üniversitesi', 'dr_ogr_uyesi', 'fen');

    // Yönerge: "Gereken en az puanın %50 fazlasının sağlanması durumunda
    // (225 puan) yurt dışında bulunma koşulu aranmaz."
    $yurtdisi = fn (array $faaliyetler, Profil $p) => collect($depo->degerlendir($esik, $faaliyetler, $p)->kosullar())
        ->first(fn (SartSonucu $k) => str_contains($k->aciklama, 'yurt dışı'));

    $bos = new Profil(doktoraTarihi: Carbon::parse('2015-01-01'), yurtdisiAy: 0);
    expect($yurtdisi([], $bos)->saglandi())->toBeFalse();

    // Üç Q1 makale = 225 puan → telafi devreye girer.
    $q1 = fn () => sartFaaliyet('SCIE/SSCI (Q1)', tarih: '2020-01-01');
    $sonuc = $yurtdisi([$q1(), $q1(), $q1()], $bos);

    expect($sonuc->saglandi())->toBeTrue()
        ->and($sonuc->telafiIleSaglandi())->toBeTrue();
});

test('Gazi alan grubunu fakülteye göre belirliyor', function () {
    $depo = sartDepo();

    // Yönergenin md. 6 tablosu sezgisel değil: Gazi Eğitim Fakültesi, Yabancı
    // Diller YO ve Spor Bilimleri Fakültesi SOSYAL BİLİMLER kriterlerine tabi.
    // Bu yüzden egitim/filoloji/spor alanları A3'e bağlandı.
    $sosyal = $depo->bul('Gazi Üniversitesi', 'docentlik', 'sosyal');

    // `anahtar` alan adıyla soneklendiği için kaynak kayıt `notlar` ile eşleşir.
    foreach (['egitim', 'filoloji', 'spor'] as $alan) {
        expect($depo->bul('Gazi Üniversitesi', 'docentlik', $alan)['notlar'])
            ->toBe($sosyal['notlar'], "{$alan} A3'e bağlı olmalı");
    }

    // Madde 6 tablosunda olmayan alanlarda eşik üretilmedi.
    foreach (['ilahiyat', 'hukuk', 'guzel_sanatlar', 'ziraat'] as $alan) {
        expect($depo->bul('Gazi Üniversitesi', 'docentlik', $alan))->toBeNull();
    }

    // Sağlıkta yayın sayısı düşük (2) ama Q1-Q2 şartı var; Fen'de 4 yayın
    // Q1-Q3'ten yeterli. İkisi farklı kümeler.
    $gerekli = function (string $alan) use ($depo): int {
        $esik = $depo->bul('Gazi Üniversitesi', 'docentlik', $alan);

        return collect($depo->degerlendir($esik, [], new Profil)->kosullar())
            ->first(fn (SartSonucu $k) => str_contains($k->aciklama, 'en az') && str_contains($k->aciklama, 'yayın'))->gerekli;
    };

    expect($gerekli('saglik'))->toBe(2)
        ->and($gerekli('fen'))->toBe(4);
});

test('Gazi proje koşulu makaleyle telafi edilebiliyor', function () {
    $depo = sartDepo();
    $esik = $depo->bul('Gazi Üniversitesi', 'docentlik', 'fen');
    $profil = new Profil(doktoraTarihi: Carbon::parse('2015-01-01'));

    $proje = fn (array $faaliyetler) => collect($depo->degerlendir($esik, $faaliyetler, $profil)->kosullar())
        ->first(fn (SartSonucu $k) => str_contains($k->aciklama, 'projede yürütücü'));

    expect($proje([])->saglandi())->toBeFalse();

    // Yönerge: "Bu kriter sağlanamıyorsa … 1a-c kapsamında 30 puan almak."
    // Bir Q1 makale 40 puan → telafi devreye girer.
    $sonuc = $proje([sartFaaliyet('SCIE/SSCI (Q1)', tarih: '2020-01-01')]);

    expect($sonuc->saglandi())->toBeTrue()
        ->and($sonuc->telafiIleSaglandi())->toBeTrue();
});

test('Ankara iki katmanlı baraj uyguluyor', function () {
    $depo = sartDepo();
    $profil = new Profil(doktoraTarihi: Carbon::parse('2015-01-01'));

    // Fen/Mühendislik/Sağlıkta iki ayrı baraj var: dar makale kümesinden
    // (1A-1B) 190 VE geniş kümeden (1A-1G) 230. Sosyal'de tek baraj.
    $esik = $depo->bul('Ankara Üniversitesi', 'docentlik', 'fen');
    $kosullar = collect($depo->degerlendir($esik, [], $profil)->kosullar())
        ->filter(fn (SartSonucu $k) => str_contains($k->aciklama, 'puan'))
        ->map(fn (SartSonucu $k) => $k->gerekli)->values()->all();

    expect($kosullar)->toBe([190, 230]);

    // TR-Dizin makalesi geniş kümeye girer, dar kümeye girmez.
    $trDizin = fn () => sartFaaliyet('TR Dizin', tarih: '2020-01-01');
    $sonuc = $depo->degerlendir($esik, [$trDizin(), $trDizin()], $profil);

    $puan = fn (string $parca) => collect($sonuc->kosullar())
        ->first(fn (SartSonucu $k) => str_contains($k->aciklama, $parca))->mevcut;

    expect($puan('(1A-1B)'))->toBe(0)
        ->and($puan('(1A-1G)'))->toBe(30);

    // Bölüm başlıklarında adı geçmeyen alanlarda eşik üretilmedi.
    foreach (['egitim', 'hukuk', 'ilahiyat', 'mimarlik', 'ziraat', 'spor', 'filoloji'] as $alan) {
        expect($depo->bul('Ankara Üniversitesi', 'docentlik', $alan))->toBeNull();
    }
});

test('yayın türü aynı dergideki çalışmaları farklı puanlıyor', function () {
    $katalog = sartDepo()->katalog('ege-2026');
    $kodlar = array_keys($katalog->maddeler);

    // Ege 1(a) Q1 özgün makale 75, 1(b) Q1 derleme 60, 1(c) Q1 editöre mektup 25.
    // Üçü de aynı dergide; ayrım yalnızca yayın türünden okunabiliyor.
    $puan = function (?string $tur) use ($katalog, $kodlar): int {
        $f = sartFaaliyet('SCIE/SSCI (Q1)', tarih: '2020-01-01');
        $f->yayin_turu = $tur;

        return $katalog->puan($f, $kodlar);
    };

    expect($puan('ozgun_makale'))->toBe(75)
        ->and($puan('derleme'))->toBe(60)
        ->and($puan('vaka_teknik_not'))->toBe(25)
        ->and($puan('kisa_makale'))->toBe(25);

    // Türü girilmemiş kayıt özgün araştırma makalesi sayılır — formun
    // varsayılanı da bu. Alternatifi hiçbir maddeye uymayıp sessizce 0 almaktı.
    expect($puan(null))->toBe(75);

    // Türe duyarsız cetvellerde ayrım yok: madde `turler` bildirmiyorsa
    // derleme de özgün makale de aynı puanı alır.
    $gazi = sartDepo()->katalog('gazi-2024');
    $gaziKodlar = array_keys($gazi->maddeler);
    $derleme = sartFaaliyet('SCIE/SSCI (Q1)', tarih: '2020-01-01');
    $derleme->yayin_turu = 'derleme';

    expect($gazi->puan($derleme, $gaziKodlar))->toBe(40);
});

test('sanatsal etkinlik Güzel Sanatlar barajına giriyor (Ankara)', function () {
    $depo = sartDepo();
    $esik = $depo->bul('Ankara Üniversitesi', 'docentlik', 'guzel_sanatlar');
    $profil = new Profil(doktoraTarihi: Carbon::parse('2015-01-01'));

    $baraj = fn (array $faaliyetler) => collect($depo->degerlendir($esik, $faaliyetler, $profil)->kosullar())
        ->first(fn (SartSonucu $k) => str_contains($k->aciklama, 'sanatsal etkinlik'))->mevcut;

    expect($baraj([]))->toBe(0);

    // Uluslararası kişisel sergi 3s maddesinden 40 puan.
    $sergi = sartFaaliyet('Kişisel Etkinlik (Uluslararası)', Kategori::SanatselEtkinlik,
        yazarRolu: null, tarih: '2020-01-01');

    expect($baraj([$sergi]))->toBe(40);

    // Mersin'in konservatuvar etiketleri de tanınıyor — Ankara c) maddesi
    // solistlik, resital ve orkestra şefliğini tek satırda topluyor.
    $resital = sartFaaliyet('Resital (Uluslararası)', Kategori::SanatselEtkinlik,
        yazarRolu: null, tarih: '2020-01-01');

    expect($baraj([$resital]))->toBe(40);
});

test('müzik/dans metot kitabı Ege güzel sanatlar yayın sayısına giriyor', function () {
    $depo = sartDepo();
    $esik = $depo->bul('Ege Üniversitesi', 'dr_ogr_uyesi', 'guzel_sanatlar');
    $profil = new Profil(doktoraTarihi: Carbon::parse('2015-01-01'));

    // Yönerge md. 12.9 bu kalemi ADIYLA sayıyor: "… 10.4 (k, l) maddelerinden
    // birinde başlıca yazar olmak koşulu ile dört yayını olmak."
    $metot = fn () => sartFaaliyet('Ders / Metot Kitabı', Kategori::Kitap,
        yazarRolu: 'tek', tarih: '2020-01-01');

    $sayi = collect($depo->degerlendir($esik, [$metot(), $metot()], $profil)->kosullar())
        ->first(fn (SartSonucu $k) => str_contains($k->aciklama, 'en az 4'))->mevcut;

    expect($sayi)->toBe(2);

    // Fen alanında aynı kalem sayılmaz: yönerge orada yalnızca 1(a) diyor.
    $fen = $depo->bul('Ege Üniversitesi', 'dr_ogr_uyesi', 'fen');
    $fenSayi = collect($depo->degerlendir($fen, [$metot(), $metot()], $profil)->kosullar())
        ->first(fn (SartSonucu $k) => str_contains($k->aciklama, 'en az 4'))->mevcut;

    expect($fenSayi)->toBe(0);
});

test('YTÜ 1(a) kümesi Q4 makalesini kapsamıyor', function () {
    $depo = sartDepo();
    $esik = $depo->bul('Yıldız Teknik Üniversitesi', 'dr_ogr_uyesi', 'muhendislik');
    $profil = new Profil(doktoraTarihi: Carbon::parse('2015-01-01'));

    // Yönergede Q1-Q3 "a" bendinin alt kırılımları, Q4 ise ESCI ile birlikte
    // ayrı "b" bendi. EK-2'nin 1(a) ile 1(a,b,c) satırları arasındaki fark bu.
    // Koşul, açıklama metnine değil `madde` alanına göre aranıyor: açıklama
    // adaya gösterilen serbest metin, madde ise yönergenin kendi kodu.
    $puan = function (string $kaynak, string $madde) use ($depo, $esik, $profil): int {
        $f = sartFaaliyet($kaynak, tarih: '2020-01-01');

        return collect($depo->degerlendir($esik, [$f], $profil)->kosullar())
            ->first(fn (SartSonucu $k) => $k->madde === $madde)->mevcut;
    };

    expect($puan('SCIE/SSCI (Q3)', 'EK-2 · 1(a)'))->toBe(15)
        ->and($puan('SCIE/SSCI (Q4)', 'EK-2 · 1(a)'))->toBe(0)
        ->and($puan('SCIE/SSCI (Q4)', 'EK-2 · 1(a,b,c)'))->toBe(12);

    // Bölüm ortalaması koşulu adayın dosyasından türetilemiyor — beyan.
    $sonuc = $depo->degerlendir($esik, [], $profil);
    expect(collect($sonuc->beyanlar())->contains(
        fn (SartSonucu $k) => str_contains($k->aciklama, 'puan ortalamasının üzerinde')
    ))->toBeTrue();
});

test('Kocaeli kümülatif dergi kademelerini iç içe sayıyor', function () {
    $depo = sartDepo();
    $esik = $depo->bul('Kocaeli Üniversitesi', 'dr_ogr_uyesi', 'fen');
    $profil = new Profil(doktoraTarihi: Carbon::parse('2015-01-01'));

    // Koşullar iç içe kümeler istiyor: "A.1-A.2'den ≥1, A.1-A.4'ten ≥2".
    // Q1-Q2'deki makale her iki sayıya da girer.
    $q1 = fn () => sartFaaliyet('SCIE/SSCI (Q1)', tarih: '2020-01-01');
    $q3 = fn () => sartFaaliyet('SCIE/SSCI (Q3)', tarih: '2020-01-01');

    $sayac = function (array $faaliyetler, string $parca) use ($depo, $esik, $profil): int {
        return collect($depo->degerlendir($esik, $faaliyetler, $profil)->kosullar())
            ->first(fn (SartSonucu $k) => str_contains($k->aciklama, $parca))->mevcut;
    };

    $dosya = [$q1(), $q3()];

    expect($sayac($dosya, 'Q1-Q2 dergide'))->toBe(1)
        ->and($sayac($dosya, 'Q1-Q4 dergide'))->toBe(2);

    // Güzel Sanatlarda sanatsal etkinlik koşulu ek makaleyle telafi ediliyor.
    $gs = $depo->bul('Kocaeli Üniversitesi', 'dr_ogr_uyesi', 'guzel_sanatlar');
    $sanat = collect($depo->degerlendir($gs, [$q1()], $profil)->kosullar())
        ->first(fn (SartSonucu $k) => str_contains($k->aciklama, 'Sanatsal etkinlik koşulu'));

    expect($sanat->telafiIleSaglandi())->toBeTrue();
});

test('Marmara yardımcı doçent koşulları Dr. Öğr. Üyesi kadrosuna bağlandı', function () {
    $depo = sartDepo();

    // Yönerge 2018 öncesi "yardımcı doçent" diyor; kadro yeniden adlandırıldı,
    // koşullar aynı kadroya ait. MADDE 7 bu yüzden dr_ogr_uyesi altında.
    $esik = $depo->bul('Marmara Üniversitesi', 'dr_ogr_uyesi', 'fen');
    expect($esik)->not->toBeNull()
        ->and($esik['notlar'])->toContain('MADDE 7');

    // Yalnızca Tablo 2 girildi; diğer tabloların alanlarında eşik yok.
    foreach (['sosyal', 'hukuk', 'ilahiyat', 'guzel_sanatlar', 'muhendislik', 'spor', 'filoloji'] as $alan) {
        expect($depo->bul('Marmara Üniversitesi', 'dr_ogr_uyesi', $alan))->toBeNull();
    }

    // Koşullar madde numarası ARALIKLARINA atıf yapıyor; birincil indeksli bir
    // makale hem "1-16" hem toplam barajına girer.
    $profil = new Profil(doktoraTarihi: Carbon::parse('2015-01-01'), yds: 70);
    $q1 = sartFaaliyet('SCIE/SSCI (Q1)', tarih: '2020-01-01');
    $sonuc = $depo->degerlendir($esik, [$q1], $profil);

    $puan = fn (string $parca) => collect($sonuc->kosullar())
        ->first(fn (SartSonucu $k) => str_contains($k->aciklama, $parca))->mevcut;

    expect($puan('faaliyet aralıklarından'))->toBe(48)
        ->and($puan('Tüm faaliyetlerden'))->toBe(48);
});

test('Erciyes yayın barajı alan grubuna göre farklı küme sayıyor', function () {
    $depo = sartDepo();
    $profil = new Profil(doktoraTarihi: Carbon::parse('2015-01-01'), yds: 70);

    // Fen/Sağlıkta yayın barajı yalnızca WoS çeyrekli dergilerden (1a-d);
    // sosyal gruplarda ESCI ve TR Dizin de sayılıyor (1a-f + kitap).
    $esci = fn () => sartFaaliyet('ESCI / Scopus', tarih: '2020-01-01');

    $yayinPuani = function (string $alan) use ($depo, $esci, $profil): int {
        $esik = $depo->bul('Erciyes Üniversitesi', 'dr_ogr_uyesi', $alan);

        return collect($depo->degerlendir($esik, [$esci()], $profil)->kosullar())
            ->first(fn (SartSonucu $k) => str_starts_with((string) $k->madde, 'Tablo · '))->mevcut;
    };

    expect($yayinPuani('fen'))->toBe(0)
        ->and($yayinPuani('sosyal'))->toBe(15);

    // Yayın türü ayrımı Erciyes'te tam karşılığını buluyor: aynı Q1 dergide
    // özgün makale 60, kısa makale 45, vaka raporu 30 puan.
    $katalog = $depo->katalog('erciyes-2024');
    $kodlar = array_keys($katalog->maddeler);
    $puan = function (string $tur) use ($katalog, $kodlar): int {
        $f = sartFaaliyet('SCIE/SSCI (Q1)', tarih: '2020-01-01');
        $f->yayin_turu = $tur;

        return $katalog->puan($f, $kodlar);
    };

    expect($puan('ozgun_makale'))->toBe(60)
        ->and($puan('kisa_makale'))->toBe(45)
        ->and($puan('vaka_teknik_not'))->toBe(30);
});

test('Cerrahpaşa girişimci koşulu alan başına farklı telafi taşıyor', function () {
    $depo = sartDepo();
    $profil = new Profil(doktoraTarihi: Carbon::parse('2015-01-01'), yds: 70);
    $q1 = fn () => sartFaaliyet('SCIE/SSCI (Q1)', tarih: '2020-01-01');

    // Yönerge: proje/patent koşulu sağlanamıyorsa sağlıkta makale sayısı
    // 3'ten 5'e, sosyalde 1'den 2'ye çıkarak karşılanıyor.
    $telafi = function (string $alan, int $makale) use ($depo, $q1, $profil): SartSonucu {
        $esik = $depo->bul('İstanbul Üniversitesi-Cerrahpaşa', 'dr_ogr_uyesi', $alan);
        $faaliyetler = array_map(fn () => $q1(), range(1, $makale));

        return collect($depo->degerlendir($esik, $faaliyetler, $profil)->kosullar())
            ->first(fn (SartSonucu $k) => str_contains($k->aciklama, 'patent başvurusu'));
    };

    expect($telafi('fen', 3)->telafiIleSaglandi())->toBeFalse()
        ->and($telafi('fen', 5)->telafiIleSaglandi())->toBeTrue();

    expect($telafi('sosyal', 1)->telafiIleSaglandi())->toBeFalse()
        ->and($telafi('sosyal', 2)->telafiIleSaglandi())->toBeTrue();

    // Yönergede tanımlanmayan alanlarda eşik üretilmedi.
    foreach (['hukuk', 'ilahiyat', 'ziraat', 'spor'] as $alan) {
        expect($depo->bul('İstanbul Üniversitesi-Cerrahpaşa', 'dr_ogr_uyesi', $alan))->toBeNull();
    }
});

test('yönerge dosyaları birbirinin değişkenlerini ezmiyor', function () {
    // `require` çağrıldığı metodun kapsamında çalışır. Eşiklerini bir döngüyle
    // üreten bir yönerge dosyası yerel `$esikler` değişkeni kullandığında,
    // okuyucunun aynı adlı biriktiricisini eziyor ve kendinden ÖNCE okunmuş
    // dosyalar sessizce kayboluyordu. Alfabetik olarak Çukurova'dan önce gelen
    // üniversitelerin hepsi listeden düşmüştü.
    $depo = sartDepo();
    $universiteler = $depo->universiteler();

    expect($universiteler)->toContain('Afyon Kocatepe Üniversitesi')
        ->and($universiteler)->toContain('Atatürk Üniversitesi')
        ->and($universiteler)->toContain('Çukurova Üniversitesi')
        ->and($universiteler)->toContain('Yıldız Teknik Üniversitesi');
});

test('Çukurova on iki temel alanın üçünde de kadro eşiği üretiyor', function () {
    $depo = sartDepo();
    $alanlar = array_map(fn (TemelAlan $a) => $a->value, TemelAlan::cases());

    foreach ($alanlar as $alan) {
        foreach (['dr_ogr_uyesi', 'docentlik', 'profesorluk'] as $kadro) {
            expect($depo->bul('Çukurova Üniversitesi', $kadro, $alan))
                ->not->toBeNull("Çukurova / {$kadro} / {$alan}");
        }
    }
});

test('Çukurova doçent asgari puanı alan grubuna göre değişiyor', function () {
    $depo = sartDepo();
    $profil = new Profil(doktoraTarihi: Carbon::parse('2015-01-01'), yds: 70);

    // EK 1: Mühendislik doçentliği 240 puan isterken Hukuk 120 istiyor. Aynı
    // faaliyet listesi birinde yetip diğerinde yetmemeli.
    $toplamKosulu = function (string $alan) use ($depo, $profil): SartSonucu {
        $esik = $depo->bul('Çukurova Üniversitesi', 'docentlik', $alan);
        // 90 puanlık iki Q1 makale = 180 puan.
        $faaliyetler = array_map(
            fn () => sartFaaliyet('SCIE/SSCI (Q1)', tarih: '2020-01-01'),
            range(1, 2),
        );

        return collect($depo->degerlendir($esik, $faaliyetler, $profil)->kosullar())
            ->first(fn (SartSonucu $k) => str_contains($k->aciklama, 'EK 2 kalemlerinden'));
    };

    expect($toplamKosulu('hukuk')->durum)->toBe(Durum::Saglandi)
        ->and($toplamKosulu('muhendislik')->durum)->toBe(Durum::Saglanmadi);
});

test('Selçuk on iki temel alanın cetvelini de yüklüyor', function () {
    $depo = sartDepo();

    // Dosya `cetveller` anahtarıyla on iki tabloyu birden döndürüyor; biri
    // eksik yüklenirse o alanın eşiği sessizce puansız kalırdı.
    foreach (array_map(fn (TemelAlan $a) => $a->value, TemelAlan::cases()) as $alan) {
        expect($depo->katalog("selcuk-2024-{$alan}"))->not->toBeNull("selcuk-2024-{$alan}");
    }

    // Alanlar aynı kalemi farklı puanlıyor: Eğitim'de uluslararası indeksli
    // makale 10, Spor'da 6 puan.
    $puan = function (string $alan, string $kod) use ($depo): int {
        return $depo->katalog("selcuk-2024-{$alan}")->maddeler[$kod]['puan'];
    };

    expect($puan('egitim', '1a'))->toBe(20)
        ->and($puan('egitim', '1c'))->toBe(10)
        ->and($puan('spor', '1c'))->toBe(6);
});

test('Selçuk on iki temel alanın üç kadrosunda da eşik üretiyor', function () {
    $depo = sartDepo();

    foreach (array_map(fn (TemelAlan $a) => $a->value, TemelAlan::cases()) as $alan) {
        foreach (['dr_ogr_uyesi', 'docentlik', 'profesorluk'] as $kadro) {
            expect($depo->bul('Selçuk Üniversitesi', $kadro, $alan))->not->toBeNull("Selçuk / {$kadro} / {$alan}");
        }
    }
});

test('Selçuk şart ağacındaki her madde referansı kendi cetvelinde karşılık buluyor', function () {
    // Bölüm numaraları alanlar arasında kayıyor: atıf Eğitim'de 4, Fen'de 3,
    // Güzel Sanatlar'da 5. Yanlış numara yazılırsa koşul hata vermez, sessizce
    // hiçbir faaliyeti saymaz ve aday koşulu sağlayamaz hâle gelir.
    $depo = sartDepo();
    $karsiliksiz = [];

    $gez = function (array $dugum, MaddeKatalogu $katalog, string $anahtar) use (&$gez, &$karsiliksiz): void {
        foreach ($dugum['maddeler'] ?? [] as $desen) {
            if ($katalog->coz([$desen]) === []) {
                $karsiliksiz[] = "{$anahtar} :: {$desen}";
            }
        }

        foreach ($dugum['cocuklar'] ?? [] as $cocuk) {
            $gez($cocuk, $katalog, $anahtar);
        }

        if (isset($dugum['telafi'])) {
            $gez($dugum['telafi'], $katalog, $anahtar);
        }
    };

    foreach ($depo->dogrulanmisEsikler() as $esik) {
        $katalog = $depo->katalog($esik['cetvel']);
        expect($katalog)->not->toBeNull($esik['cetvel']);
        $gez($esik['sart'], $katalog, $esik['anahtar']);
    }

    expect($karsiliksiz)->toBe([]);
});

test('Selçuk Eğitim Bilimleri alt barajları toplam puandan bağımsız işliyor', function () {
    $depo = sartDepo();
    $profil = new Profil(doktoraTarihi: Carbon::parse('2015-01-01'), yds: 70);
    $esik = $depo->bul('Selçuk Üniversitesi', 'dr_ogr_uyesi', 'egitim');

    // Dört adet 20 puanlık WoS makalesi toplam barajı (70) ve uluslararası
    // makale barajını aşıyor; ama Eğitim Bilimleri ayrıca ULUSAL makaleden
    // 20 puan istiyor. Toplam puan yeterli diye sonuç olumlu çıkmamalı.
    $makaleler = array_map(
        fn () => sartFaaliyet('SCIE/SSCI (Q1)', tarih: '2020-01-01'),
        range(1, 4),
    );

    $kosullar = collect($depo->degerlendir($esik, $makaleler, $profil)->kosullar());
    $bul = fn (string $parca) => $kosullar->first(fn (SartSonucu $k) => str_contains($k->aciklama, $parca));

    $madde = fn (string $m) => $kosullar->first(fn (SartSonucu $k) => $k->madde === $m);

    expect($bul('toplam en az 70 puan')->durum)->toBe(Durum::Saglandi)
        ->and($madde('Özel Kriterler I-a')->durum)->toBe(Durum::Saglandi)
        ->and($madde('Özel Kriterler I-b')->durum)->toBe(Durum::Saglanmadi);
});

test('Sakarya cetveli çakışan ölçütlerde kodu koruyup en düşük puanı veriyor', function () {
    $katalog = sartDepo()->katalog('sakarya-2026');

    // Sakarya'nın eşik tabloları "1. BÖLÜM" gibi kümeleri kodları tek tek
    // sayarak tanımlıyor. Aynı kaynak etiketine düşen ölçütler birleştirilseydi
    // kümede anılan kod cetvelde bulunamaz, küme sessizce eksik puanlanırdı.
    // Bu yüzden kod korunur; çakışmada puan güvenli olan (düşük) tarafa çekilir.
    expect($katalog->maddePuani('1.1a'))->toBe(90);

    // 2.1a (ERC yürütücülüğü, 340) ile 2.1d (MSCA yürütücülüğü, 270) kaynak
    // sözlüğünde ayrılamıyor; ikisi de 270 taşımalı.
    expect($katalog->maddePuani('2.1a'))->toBe(270)
        ->and($katalog->maddePuani('2.1d'))->toBe(270);

    // Uluslararası (50) ve ulusal (40) yayınevi kitabı da tek etiket.
    expect($katalog->maddePuani('3.2'))->toBe(40)
        ->and($katalog->maddePuani('3.5'))->toBe(40);
});

test('Sakarya bölüm barajları toplam puandan bağımsız işliyor', function () {
    $depo = sartDepo();
    $profil = new Profil(doktoraTarihi: Carbon::parse('2015-01-01'), yds: 70);
    $esik = $depo->bul('Sakarya Üniversitesi', 'docentlik', 'muhendislik');

    // Yirmi adet 90 puanlık Q1 makalesi = 1800 puan: TOPLAM (1600) ve 1./2.
    // BÖLÜM barajlarını aşar. Ama 4. BÖLÜM kurumsal/toplumsal katkı ölçütlerini
    // sayıyor; makaleyle sağlanamaz.
    $makaleler = array_map(
        fn () => sartFaaliyet('SCIE/SSCI (Q1)', tarih: '2020-01-01'),
        range(1, 20),
    );

    $kosullar = collect($depo->degerlendir($esik, $makaleler, $profil)->kosullar());
    $bul = fn (string $parca) => $kosullar->first(fn (SartSonucu $k) => str_contains($k->aciklama, $parca));

    $madde = fn (string $m) => $kosullar->first(fn (SartSonucu $k) => $k->madde === $m);

    expect($bul('EK-1 kalemlerinden toplam en az 1600 puan')->durum)->toBe(Durum::Saglandi)
        ->and($madde('2.3 · 1. BÖLÜM')->durum)->toBe(Durum::Saglandi)
        ->and($madde('2.3 · 4. BÖLÜM')->durum)->toBe(Durum::Saglanmadi);
});

test('Sakarya fakülte grupları temel alanlara çakışmadan dağılıyor', function () {
    $depo = sartDepo();

    // 2.3 (Mühendislik + Fen'in Kimya/Fizik/Biyoloji bölümleri) ile 2.4 (Fen'in
    // Matematik bölümü) ikisi de "fen" sayılsaydı aynı alanda iki eşik çakışırdı.
    expect($depo->bul('Sakarya Üniversitesi', 'docentlik', 'muhendislik'))->not->toBeNull()
        ->and($depo->bul('Sakarya Üniversitesi', 'docentlik', 'fen'))->not->toBeNull();

    foreach (['egitim', 'sosyal', 'ilahiyat', 'hukuk', 'mimarlik', 'guzel_sanatlar'] as $alan) {
        expect($depo->bul('Sakarya Üniversitesi', 'profesorluk', $alan))->not->toBeNull($alan);
    }

    // Yönergede karşılığı olmayan alanlar eşik üretmemeli.
    foreach (['saglik', 'filoloji', 'spor', 'ziraat'] as $alan) {
        expect($depo->bul('Sakarya Üniversitesi', 'docentlik', $alan))->toBeNull($alan);
    }
});
