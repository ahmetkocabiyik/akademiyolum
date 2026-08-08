<?php

use App\Enums\Kategori;
use App\Enums\TemelAlan;
use App\Models\Faaliyet;
use App\Models\User;
use App\Services\Scoring\Sart\Durum;
use App\Services\Scoring\Sart\Profil;
use App\Services\Scoring\Sart\SartDeposu;
use App\Services\Scoring\Sart\SartSonucu;
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
 * Ağaçtaki belirli bir düğümü açıklamasının bir parçasıyla bulur.
 */
function sartDugum(SartSonucu $sonuc, string $parca): SartSonucu
{
    $bulunan = $sonuc->topla(fn (SartSonucu $d) => str_contains($d->aciklama, $parca));

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

    $sonuc = $depo->degerlendir($esik, [
        sartFaaliyet('SCIE/SSCI (Q3)'),   // 1.4 → 90
        sartFaaliyet('SCIE/SSCI (Q3)'),   // 90
        sartFaaliyet('SCIE/SSCI (Q3)'),   // 90
    ], new Profil(yds: 75));

    expect($sonuc->durum)->toBe(Durum::Saglandi)
        ->and(sartDugum($sonuc, 'toplam en az 100 puan')->mevcut)->toBe(270)
        ->and(sartDugum($sonuc, 'En az 3 yayın')->mevcut)->toBe(3);
});

test('YDS girilmemişse koşul sağlanmadı değil BELİRSİZ olur', function () {
    $depo = sartDepo();
    $esik = $depo->bul('Akdeniz Üniversitesi', 'dr_ogr_uyesi', 'fen');

    $sonuc = $depo->degerlendir($esik, [
        sartFaaliyet('SCIE/SSCI (Q3)'),
        sartFaaliyet('SCIE/SSCI (Q3)'),
        sartFaaliyet('SCIE/SSCI (Q3)'),
    ], new Profil);

    expect(sartDugum($sonuc, 'yabancı dil')->durum)->toBe(Durum::Belirsiz)
        ->and($sonuc->durum)->toBe(Durum::Belirsiz)
        ->and($sonuc->belirsizler())->toHaveCount(1);
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
    $esik = $depo->bul('Akdeniz Üniversitesi', 'docentlik', 'fen');

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
    $esik = $depo->bul('Akdeniz Üniversitesi', 'docentlik', 'fen');
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
