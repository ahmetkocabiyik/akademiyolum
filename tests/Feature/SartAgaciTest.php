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

test('her eşiğin üniversitesi universiteler.php\'de tanımlıdır', function () {
    // Yönerge Analizi ekranı `Universite` tablosunu gezip her satırın adıyla
    // `bul()` çağırıyor. Adı listede geçmeyen bir üniversitenin eşikleri
    // hesaplanır, bu dosyadaki öteki testleri geçer ve adaya HİÇ GÖRÜNMEZ.
    // Altı üniversite bu yüzden bir süre sessizce görünmez kaldı.
    /** @var list<array{0: string, 1: string, 2: string}> $satirlar */
    $satirlar = require database_path('data/universiteler.php');
    $liste = array_column($satirlar, 0);

    $eksik = collect(sartDepo()->esikler())
        ->pluck('universite')
        ->unique()
        ->reject(fn (string $ad) => in_array($ad, $liste, true))
        ->values()
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

/**
 * "BU PUANIN EN AZ YARISI …" ASGARİ PUANIN YARISIDIR, TOPLAMIN DEĞİL.
 *
 * Akdeniz'in eşik tablolarında üst simge "En az puan" SÜTUNUNA bağlı ve
 * dipnot "BU PUANIN en az yarısı 1. Bölüm'den karşılanmış olmalıdır" diyor.
 * "Bu puan" sütundaki değer, yani asgari puan (Dr. 100 · Doçent 300 ·
 * Profesör 500) — adayın kendi toplamı değil. İlk girişte oran adayın
 * toplamına bağlanmıştı; bu, barajın çok üstünde puanı olan ama makale
 * ağırlığı düşük adaya YANLIŞ "sağlanmadı" gösteriyordu.
 */
test('Akdeniz makale barajı asgari puanın yarısı, adayın toplamının değil', function () {
    $depo = sartDepo();
    $esik = $depo->bul('Akdeniz Üniversitesi', 'dr_ogr_uyesi', 'sosyal');

    // Makale 15 (TR Dizin) + 4 kitap × 30 = 135 toplam. Eski (oransal) okuma
    // 68 puan makale isterdi; kaynağın istediği ise sabit 50.
    $sonuc = $depo->degerlendir($esik, [
        sartFaaliyet('TR Dizin'),
        sartFaaliyet('Uluslararası/Ulusal Kitap', Kategori::Kitap),
        sartFaaliyet('Uluslararası/Ulusal Kitap', Kategori::Kitap),
        sartFaaliyet('Uluslararası/Ulusal Kitap', Kategori::Kitap),
        sartFaaliyet('Uluslararası/Ulusal Kitap', Kategori::Kitap),
    ], new Profil(yds: 70));

    $makale = sartDugum($sonuc, 'Bilimsel makalelerinizden en az 50 puan');

    expect($makale->gerekli)->toBe(50)
        ->and($makale->mevcut)->toBe(15)
        ->and($makale->durum)->toBe(Durum::Saglanmadi);
});

test('Güzel Sanatlar %40 barajı Hukuk/İlahiyat %50 barajından ayrı kayıttır', function () {
    $depo = sartDepo();

    $gs = $depo->bul('Akdeniz Üniversitesi', 'dr_ogr_uyesi', 'guzel_sanatlar');
    $hukuk = $depo->bul('Akdeniz Üniversitesi', 'dr_ogr_uyesi', 'hukuk');

    $faaliyetler = [sartFaaliyet('TR Dizin')];
    $profil = new Profil(yds: 70);

    // Asgari puan ikisinde de 100; GRUP 3'ün dipnot 4'ü Güzel Sanatlara %40,
    // dipnot 3'ü Hukuk ve İlahiyata yarısını istiyor.
    expect(sartDugum($depo->degerlendir($gs, $faaliyetler, $profil), 'en az 40 puan')->gerekli)->toBe(40)
        ->and(sartDugum($depo->degerlendir($hukuk, $faaliyetler, $profil), 'en az 50 puan')->gerekli)->toBe(50);
});

/**
 * Motorun ORANSAL düğümü (min_oran) korpusta TEK BİR yerde doğru: Çanakkale
 * "ADAYIN TOPLAM PUANININ %65'ini" diyor, yani gerçekten adayın kendi
 * toplamına bağlı. Akdeniz, Karamanoğlu ve Trakya'da aynı kalıp sanılmıştı
 * ama üçünde de taban SABİT bir barajdı; 04.09.2026'da sabit `puanDan`
 * tabanına çevrildiler.
 */
test('oransal koşul yalnız adayın kendi toplamına bağlıyken kullanılıyor', function () {
    $depo = sartDepo();
    $esik = $depo->bul('Çanakkale Onsekiz Mart Üniversitesi', 'dr_ogr_uyesi', 'sosyal');

    expect($esik)->not->toBeNull();

    $oranli = function (array $dugum) use (&$oranli): bool {
        if (isset($dugum['min_oran'])) {
            return true;
        }

        foreach ($dugum['cocuklar'] ?? [] as $cocuk) {
            if ($oranli($cocuk)) {
                return true;
            }
        }

        return false;
    };

    expect($oranli($esik['sart']))->toBeTrue();

    // Öteki üçünde artık oransal düğüm kalmadı.
    foreach (['Akdeniz Üniversitesi', 'Karamanoğlu Mehmetbey Üniversitesi', 'Trakya Üniversitesi'] as $universite) {
        foreach ($depo->esikler() as $aday) {
            if ($aday['universite'] === $universite) {
                expect($oranli($aday['sart']))->toBeFalse();
            }
        }
    }
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
        ->and($baraj('saglik')->aciklama)->toContain('Yayın ve proje');

    // Güzel sanatlar: TABLO B + C sayılır, makale barajına GİRMEZ.
    expect($baraj('guzel_sanatlar')->mevcut)->toBe(70)
        ->and($baraj('guzel_sanatlar')->aciklama)->toContain('Sanatsal etkinlik');

    // Mimarlık: yönerge barajı iki listeden BİRLİKTE istiyor (md. 2.2 e-7).
    expect($baraj('mimarlik')->mevcut)->toBe(80)
        ->and($baraj('mimarlik')->aciklama)->toContain('Yayın, proje ve sanatsal etkinlik');

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

    // Açıklama adaya gösterilen serbest metin; koşul yönergenin kodunu taşıyan
    // `madde` alanından aranıyor.
    $puan = fn (string $madde) => collect($sonuc->kosullar())
        ->first(fn (SartSonucu $k) => $k->madde === $madde)->mevcut;

    expect($puan('Bölüm 1 · 1A-1B'))->toBe(0)
        ->and($puan('Bölüm 1 · 1A-1G'))->toBe(30);

    // Alan dağılımı ayrı testte; burada yalnız mimarlığın kapsam dışı olduğu.
    expect($depo->bul('Ankara Üniversitesi', 'docentlik', 'mimarlik'))->toBeNull();
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

    // Yönergenin yedi tablosu da girildi; on temel alanda eşik var. Mimarlık
    // ve Ziraat yönergenin KENDİSİNDE yok (Marmara'da o fakülteler bulunmuyor).
    foreach (['sosyal', 'hukuk', 'ilahiyat', 'guzel_sanatlar', 'muhendislik', 'spor', 'filoloji', 'egitim', 'saglik'] as $alan) {
        expect($depo->bul('Marmara Üniversitesi', 'dr_ogr_uyesi', $alan))->not->toBeNull();
    }

    foreach (['mimarlik', 'ziraat'] as $alan) {
        expect($depo->bul('Marmara Üniversitesi', 'dr_ogr_uyesi', $alan))->toBeNull();
    }

    // Koşullar madde numarası ARALIKLARINA atıf yapıyor; birincil indeksli bir
    // makale hem "1-16" hem toplam barajına girer.
    $profil = new Profil(doktoraTarihi: Carbon::parse('2015-01-01'), yds: 70);
    $q1 = sartFaaliyet('SCIE/SSCI (Q1)', tarih: '2020-01-01');
    $sonuc = $depo->degerlendir($esik, [$q1], $profil);

    $puan = fn (string $parca) => collect($sonuc->kosullar())
        ->first(fn (SartSonucu $k) => str_contains($k->aciklama, $parca))->mevcut;

    expect($puan('kalemlerinizden en az 42 puan'))->toBe(48)
        ->and($puan('Tüm faaliyetlerden'))->toBe(48);
});

test('Marmara dr. öğr. üyeliği koşulu temel alana göre gerçekten değişiyor', function () {
    $depo = sartDepo();

    // Md. 7/d on bir ayrı bent veriyor ve bunlar birbirinin kopyası değil.
    // Önceki sürüm Sağlık ve Eğitim'i de Fen kuralına bağlamıştı.
    $aciklamalar = function (string $alan) use ($depo): array {
        $esik = $depo->bul('Marmara Üniversitesi', 'dr_ogr_uyesi', $alan);

        return array_map(fn (array $d): string => $d['aciklama'], $esik['sart']['cocuklar']);
    };

    // Mühendislikte PUAN BARAJI YOK; tek koşul iki SCI-Expanded makale.
    expect($aciklamalar('muhendislik'))->toContain('SCI-Expanded kapsamındaki dergilerde en az 2 makale')
        ->and(implode(' ', $aciklamalar('muhendislik')))->not->toContain('toplam en az');

    // Sağlık iki hakemli makale + 90 puan istiyor, Fen ise tek SCI-E makale
    // + 42 puanlık ara katman + 90 puan.
    expect($aciklamalar('saglik'))->toContain('Hakemli dergilerde en az 2 makale')
        ->and($aciklamalar('fen'))->toContain('SCI-Expanded kapsamındaki bir dergide en az 1 makale')
        ->and($aciklamalar('saglik'))->not->toBe($aciklamalar('fen'));

    // Eğitimde toplam puan barajı YOK; iki dar katman var.
    expect(implode(' ', $aciklamalar('egitim')))->not->toContain('Tüm faaliyetlerden');

    // Doçentlik ve profesörlük ise alandan bağımsız: aynı cümle her alanda.
    $docent = fn (string $alan): array => array_map(
        fn (array $d): string => $d['aciklama'],
        $depo->bul('Marmara Üniversitesi', 'docentlik', $alan)['sart']['cocuklar'],
    );

    expect($docent('sosyal'))->toBe($docent('muhendislik'));
});

test('Ankara üç alan bölümünü on bir temel alana dağıtıyor', function () {
    $depo = sartDepo();

    // Yönerge üç bölüm veriyor (Fen-Mühendislik-Sağlık, Sosyal, Güzel
    // Sanatlar) ve fakülte→grup tablosu YOK. Bölüm sayısı üç olduğu için her
    // temel alan birine düşmek zorunda; belge iki yerden doğruluyor: IV/b
    // spor bilimleri fakültesini Sosyal kapsamında sayıyor, I/ı hukuk temel
    // alanına ek koşul getiriyor.
    // Anahtara temel alan soneki ekleniyor; ön eki karşılaştırmak yeterli.
    foreach (['fen', 'muhendislik', 'saglik', 'ziraat'] as $alan) {
        expect($depo->bul('Ankara Üniversitesi', 'docentlik', $alan)['anahtar'])
            ->toStartWith('ankara-docent-fen-muh-saglik');
    }

    foreach (['sosyal', 'egitim', 'filoloji', 'ilahiyat', 'spor'] as $alan) {
        expect($depo->bul('Ankara Üniversitesi', 'docentlik', $alan)['anahtar'])
            ->toStartWith('ankara-docent-sosyal');
    }

    // Mimarlık yönergede hiç geçmiyor; Ankara'da o fakülte yok.
    expect($depo->bul('Ankara Üniversitesi', 'docentlik', 'mimarlik'))->toBeNull();
});

test('Ankara hukuk barajı Sosyal ile aynı ama monografi koşulu ekliyor', function () {
    $depo = sartDepo();
    $profil = new Profil(doktoraTarihi: Carbon::parse('2015-01-01'), yurtdisiAy: 3);

    $hukuk = $depo->bul('Ankara Üniversitesi', 'dr_ogr_uyesi', 'hukuk');
    $sosyal = $depo->bul('Ankara Üniversitesi', 'dr_ogr_uyesi', 'sosyal');

    // Puan barajı aynı, koşul sayısı bir fazla: md. I/ı'nın monografisi.
    expect($hukuk)->not->toBeNull()
        ->and($hukuk['sart']['cocuklar'])->toHaveCount(count($sosyal['sart']['cocuklar']) + 1);

    // Tek yazarlı kitap koşulu karşılıyor.
    $kitap = sartFaaliyet('Uluslararası/Ulusal Kitap', Kategori::Kitap, 'tek', '2020-01-01');
    $monografi = fn (array $esik, array $faaliyetler) => collect($depo->degerlendir($esik, $faaliyetler, $profil)->kosullar())
        ->first(fn (SartSonucu $k) => str_contains($k->aciklama, 'monografik'));

    expect($monografi($hukuk, [$kitap])->saglandi())->toBeTrue();

    // Ortak yazarlı kitap karşılamıyor; Q1 telafisi iki tek yazarlı makale istiyor.
    $ortak = sartFaaliyet('Uluslararası/Ulusal Kitap', Kategori::Kitap, 'diger', '2020-01-01');
    expect($monografi($hukuk, [$ortak])->saglandi())->toBeFalse();

    $q1 = fn () => sartFaaliyet('SCIE/SSCI (Q1)', tarih: '2020-01-01', yazarRolu: 'tek');
    $telafi = $monografi($hukuk, [$ortak, $q1(), $q1()]);
    expect($telafi->saglandi())->toBeTrue()
        ->and($telafi->telafiIleSaglandi())->toBeTrue();
});

test('Ordu 2024 yönergesi on bir alanı dört kadroda ayrı ayrı tanımlıyor', function () {
    $depo = sartDepo();

    // 2024 sürümü (Senato 03.04.2024) 2017'nin yerine geçti: MADDE 14 eskisini
    // açıkça yürürlükten kaldırıyor. Eski sürüm tek tablo ve alandan bağımsız
    // baraj kullanıyordu; yenisi her temel alana ayrı tablo veriyor.
    $alanlar = ['spor', 'egitim', 'fen', 'filoloji', 'ilahiyat', 'mimarlik',
        'muhendislik', 'saglik', 'sosyal', 'ziraat', 'guzel_sanatlar'];

    foreach ($alanlar as $alan) {
        foreach (['profesorluk', 'docentlik', 'dr_ogr_uyesi', 'dr_ogr_uyesi_yeniden'] as $kadro) {
            $esik = $depo->bul('Ordu Üniversitesi', $kadro, $alan);
            // Cetvel kadroya göre varyantlanıyor: tavanlar kadroya, kitap
            // tavanı ayrıca tabloya bağlı (ordu-2024-docentlik-c120 …).
            expect($esik)->not->toBeNull("{$kadro}/{$alan}")
                ->and($esik['cetvel'])->toStartWith('ordu-2024-');
        }
    }

    // Ordu'da Hukuk Fakültesi yok; yönergenin on bir tablosunda da hukuk yok.
    expect($depo->bul('Ordu Üniversitesi', 'docentlik', 'hukuk'))->toBeNull();
});

test('Yalova yüzde tabanlı tavanı asgari puandan hesaplanıp uygulanıyor', function () {
    $depo = sartDepo();

    // Sosyal tablosu atıf tavanını yüzdeyle veriyor: "başvuru şartlarında
    // istenen asgari puanın %20'sinden fazlasını karşılayamaz." Doçentlikte
    // asgari 150, yani tavan 30. Kırk atıf 120 puan eder ama toplama 30 girer.
    $esik = $depo->bul('Yalova Üniversitesi', 'docentlik', 'sosyal');
    $profil = new Profil(doktoraTarihi: Carbon::parse('2018-01-01'), yds: 60);

    $atiflar = array_map(
        fn (): object => sartFaaliyet('WoS / Scopus', Kategori::Atif, 'tek', '2022-01-01'),
        range(1, 40),
    );

    $toplam = collect($depo->degerlendir($esik, $atiflar, $profil)->kosullar())
        ->first(fn (SartSonucu $k): bool => str_contains($k->aciklama, 'Tüm faaliyetlerden'));

    expect($toplam->mevcut)->toBe(30);

    // Yeniden atanmada asgari 40, yani tavan 8 — aynı faaliyetler, farklı tavan.
    $yeniden = $depo->bul('Yalova Üniversitesi', 'dr_ogr_uyesi_yeniden', 'sosyal');

    expect($yeniden['cetvel'])->toBe('yalova-2024-sosyal-a40')
        ->and($esik['cetvel'])->toBe('yalova-2024-sosyal-a150');
});

test('tezden üretilmiş yayın, ayrı satırı olmayan cetvelde normal satırdan sayılır', function () {
    $depo = sartDepo();

    // Aday yayınını "Tezden Üretilmiş Yayın" olarak kaydettiğinde kayıt
    // `tez_yayini` kategorisine düşüyor ve daha KABA bir indeks etiketi
    // taşıyor (SCIE/SSCI/AHCI, çeyrek yok). Yönergelerin çoğu bu yayına ayrı
    // satır vermiyor; karşılık aranmasa aday doğru etiketlediği için SIFIR
    // alırdı.
    $tezMakale = fn (): object => sartFaaliyet('SCIE/SSCI/AHCI', Kategori::TezYayini, 'tek', '2022-01-01');

    $puan = function (string $cetvel) use ($depo, $tezMakale): int {
        $katalog = $depo->katalog($cetvel);

        return $katalog->topla([$tezMakale()], $katalog->coz(['*']));
    };

    // Tez satırı OLMAYAN cetvel: normal makale satırından sayılıyor.
    expect($puan('marmara-sosyal'))->toBe(48);

    // Çeyreğe göre ayrılmış cetvelde EN DÜŞÜK satır seçilir: kaba etiket
    // hangi çeyrek olduğunu söylemiyor, Q1 saymak fazla saymak olurdu (§0).
    // Ordu: Q1 50, Q2 45, Q3 40, Q4 35.
    expect($puan('ordu-2024-docentlik'))->toBe(35);

    // Tez satırı OLAN cetvel kendi kuralını kullanır, karşılık aranmaz.
    expect($puan('marmara-egitim'))->toBe(24);

    // Yönerge o kadroda tez yayınını hiç saymıyorsa (İzmir Kâtip Çelebi
    // sosyal doçentlikte A2 grubunun tavanı 0) sonuç yine sıfır kalır.
    expect($puan('ikcu-2023-sosyal-docent'))->toBe(0);
});

test('sonradan eklenen dar sanat etiketi eski cetvelde genel satırdan sayılır', function () {
    $depo = sartDepo();

    // Kaynak sözlüğü büyüdükçe daha özel etiketler giriyor ("TV Programı
    // (Ulusal)", Dokuz Eylül'ün D bölümü için eklendi). Daha önce girilmiş
    // cetveller bu etiketi tanımıyor; satırları genel etikete yazılmış
    // ("Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)"). Karşılık aranmazsa aday
    // kaydını DAHA DOĞRU etiketlediği için sıfır alırdı.
    $katalog = $depo->katalog('marmara-guzel-sanatlar');

    $puan = fn (string $kaynak): int => $katalog->topla(
        [sartFaaliyet($kaynak, Kategori::SanatselEtkinlik, 'tek', '2022-01-01')],
        $katalog->coz(['*']),
    );

    expect($puan('Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)'))->toBeGreaterThan(0)
        ->and($puan('TV Programı (Ulusal)'))->toBe($puan('Sahne, TV, Radyo, Sinema Yapıtı (Ulusal)'));

    // Küratörlük ve koordinatörlük BİLEREK dışarıda: sergi düzenlemek, karma
    // sergiye eserle katılmaktan başka bir iş. Genel etikete bağlamak hak
    // edilmeyen puan verirdi.
    $katalogDeu = $depo->katalog('marmara-sosyal');

    expect($katalogDeu->topla(
        [sartFaaliyet('Sergi Küratörlüğü (Ulusal)', Kategori::SanatselEtkinlik, 'tek', '2022-01-01')],
        $katalogDeu->coz(['*']),
    ))->toBe(0);
});

test('Marmara Eğitim tezden üretilmiş yayını yarım puanla sayıyor', function () {
    $depo = sartDepo();
    $katalog = $depo->katalog('marmara-egitim');

    // Md. 7/d-1 dipnotu: "Yaptığı lisansüstü tez(ler)den üretilen yayınlar
    // ölçütlerde gösterilen mevcut puanın YARISI ile değerlendirilir."
    $puan = fn (Kategori $kategori, string $kaynak): int => $katalog->topla(
        [sartFaaliyet($kaynak, $kategori, 'tek', '2022-01-01')],
        $katalog->coz(['*']),
    );

    expect($puan(Kategori::Makale, 'SCIE/SSCI (Q1)'))->toBe(48)
        ->and($puan(Kategori::TezYayini, 'SCIE/SSCI/AHCI'))->toBe(24);

    // Kural YALNIZ Eğitim bendinde geçiyor. Spor da Tablo 1'i kullanıyor ama
    // kendi bendinde (7/d-11) böyle bir hüküm yok; oraya taşınmadı. Spor'da
    // tez satırı olmadığı için yayın normal makale satırından TAM puan alır.
    $spor = $depo->katalog('marmara-spor');

    expect($spor->topla(
        [sartFaaliyet('SCIE/SSCI/AHCI', Kategori::TezYayini, 'tek', '2022-01-01')],
        $spor->coz(['*']),
    ))->toBe(48);
});

test('Erzurum Teknik tavanları birim ve kadroya göre ayrı uygulanıyor', function () {
    $depo = sartDepo();

    // Tablo tavanları koşul metninin İÇİNDE ve (birim × kadro) değişiyor.
    // Eğitim (H): profesörlükte 150, doçentlikte 40, yeniden atanmada 30.
    $tavan = fn (string $birim, string $kadro): array => $depo
        ->cetveller()["erzurum-teknik-2024-{$birim}-{$kadro}"]->grupTavanlari;

    expect($tavan('edebiyat', 'profesorluk')['H'])->toBe(150)
        ->and($tavan('edebiyat', 'docentlik')['H'])->toBe(40)
        ->and($tavan('edebiyat', 'dr_ogr_uyesi_yeniden')['H'])->toBe(30);

    // Atıf (G) ayrıca birime bağlı: Edebiyat profesörlüğünde 20, Fen'in
    // matematik dışı alanlarında 100.
    expect($tavan('edebiyat', 'profesorluk')['G'])->toBe(20)
        ->and($tavan('fen-diger', 'profesorluk')['G'])->toBe(100)
        ->and($tavan('fen-matematik', 'profesorluk')['G'])->toBe(30);

    // Eşikler doğru varyanta bağlı; Edebiyat'ın iki eşik grubu (sosyal ve
    // filoloji) kaynakta tek fakülte sayfası olduğu için aynı varyantı
    // kullanıyor.
    expect($depo->bul('Erzurum Teknik Üniversitesi', 'docentlik', 'sosyal', 'Edebiyat Fakültesi')['cetvel'])
        ->toBe('erzurum-teknik-2024-edebiyat-docentlik');
});

test('Ordu kategori tavanları toplam puanı kesiyor', function () {
    $depo = sartDepo();

    // Yönerge her kategoriye "en fazla ... değerlendirmeye alınır" diyor;
    // doçentlikte bildiri tavanı 30. On uluslararası tam metin bildiri 100
    // puan eder ama toplama yalnız 30'u girmeli — tavan uygulanmazsa aday
    // barajın üstünde görünürdü ve §0 ihlal edilirdi.
    $esik = $depo->bul('Ordu Üniversitesi', 'docentlik', 'fen');
    $profil = new Profil(doktoraTarihi: Carbon::parse('2018-01-01'), yds: 60);

    $bildiriler = array_map(
        fn (): object => sartFaaliyet('Uluslararası Tam Metin', Kategori::Bildiri, 'tek', '2022-01-01'),
        range(1, 10),
    );

    $sonuc = $depo->degerlendir($esik, $bildiriler, $profil);

    $puan = fn (string $parca): int => collect($sonuc->kosullar())
        ->first(fn (SartSonucu $k): bool => str_contains($k->aciklama, $parca))->mevcut;

    expect($puan('bildirilerinizden en az 15'))->toBe(30)
        ->and($puan('Tüm faaliyetlerden'))->toBe(30);
});

test('Ordu alan farkı makale bendi seçiminde, toplam barajda değil', function () {
    $depo = sartDepo();

    $aciklamalar = function (string $alan, string $kadro) use ($depo): string {
        $esik = $depo->bul('Ordu Üniversitesi', $kadro, $alan);

        return implode(' | ', array_map(fn (array $d): string => $d['aciklama'], $esik['sart']['cocuklar']));
    };

    // Toplam baraj on bir tabloda da aynı: profesörlük 500, doçentlik 400.
    foreach (['filoloji', 'muhendislik', 'guzel_sanatlar'] as $alan) {
        expect($aciklamalar($alan, 'profesorluk'))->toContain('toplam en az 500 puan')
            ->and($aciklamalar($alan, 'docentlik'))->toContain('toplam en az 400 puan');
    }

    // Fark makale bendinde: Filoloji profesörlükte YALNIZ TR Dizin'den 120
    // isterken Mühendislik SCI-SSCI-AHCI'dan 120 istiyor.
    expect($aciklamalar('filoloji', 'profesorluk'))->toContain('TR Dizin dergilerindeki makalelerinizden en az 120 puan')
        ->and($aciklamalar('muhendislik', 'profesorluk'))->toContain('SCI, SSCI, SCI-Expanded ve AHCI dergilerindeki makalelerinizden en az 120 puan');

    // Mimarlık profesörlüğü makale bentleri arasında hiç ayrım yapmıyor:
    // tek bir makale koşulu var (A.1-A.6'dan 160), diğerlerinde iki ya da üç.
    $makaleSayisi = function (string $alan, string $kadro) use ($depo): int {
        $esik = $depo->bul('Ordu Üniversitesi', $kadro, $alan);

        return count(array_filter(
            $esik['sart']['cocuklar'],
            fn (array $d): bool => str_contains($d['aciklama'], 'makale kalemlerinizden')
                || str_contains($d['aciklama'], 'makalelerinizden en az'),
        ));
    };

    expect($makaleSayisi('mimarlik', 'profesorluk'))->toBe(1)
        ->and($makaleSayisi('muhendislik', 'profesorluk'))->toBe(3)
        ->and($makaleSayisi('filoloji', 'profesorluk'))->toBe(2);

    // Dr. öğr. üyeliğinin İLK atamasında atıf ve öğretim koşulu yok;
    // yeniden atanmada öğretim var, atıf yok.
    expect($aciklamalar('fen', 'dr_ogr_uyesi'))->not->toContain('Atıflarınızdan')
        ->and($aciklamalar('fen', 'dr_ogr_uyesi'))->not->toContain('Öğretim faaliyetlerinizden')
        ->and($aciklamalar('fen', 'dr_ogr_uyesi_yeniden'))->toContain('Öğretim faaliyetlerinizden')
        ->and($aciklamalar('fen', 'dr_ogr_uyesi_yeniden'))->not->toContain('Atıflarınızdan');
});

test('Ordu profesörlük koşulları doçentlik sonrası dönemi ölçüyor', function () {
    $depo = sartDepo();

    // Dipnot (2): profesörlük sütunundaki koşullar doçentlik unvanından
    // sonraki yayınları, atıfları, öğretim faaliyetlerini ve projeleri kapsar.
    $esik = $depo->bul('Ordu Üniversitesi', 'profesorluk', 'sosyal');
    $profil = new Profil(docentlikTarihi: Carbon::parse('2020-01-01'), yds: 60);

    // Doçentlikten ÖNCEKİ dört TR Dizin makalesi (80 puan) sayılmamalı.
    $onceki = array_map(
        fn (): object => sartFaaliyet('TR Dizin', tarih: '2018-01-01'),
        range(1, 4),
    );

    $trDizin = collect($depo->degerlendir($esik, $onceki, $profil)->kosullar())
        ->first(fn (SartSonucu $k) => str_contains($k->aciklama, 'TR Dizin dergilerindeki'));

    expect($trDizin->mevcut)->toBe(0);

    // Aynı dört makale doçentlikten SONRA olsaydı 80 puan sayılacaktı.
    $sonraki = array_map(
        fn (): object => sartFaaliyet('TR Dizin', tarih: '2022-01-01'),
        range(1, 4),
    );

    $trDizinSonra = collect($depo->degerlendir($esik, $sonraki, $profil)->kosullar())
        ->first(fn (SartSonucu $k) => str_contains($k->aciklama, 'TR Dizin dergilerindeki'));

    expect($trDizinSonra->mevcut)->toBe(80);
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
            ->first(fn (SartSonucu $k) => str_contains($k->aciklama, 'Tüm faaliyetlerden toplam en az'));
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

    expect($bul('Tüm faaliyetlerden toplam en az 1600 puan')->durum)->toBe(Durum::Saglandi)
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

    // 2.3'ün başlığı iki satır ve ikinci satırı ilk girişte düşmüştü; Tıp,
    // Sağlık Bilimleri ve Diş Hekimliği o gruba dâhil, sağlık kapsam içinde.
    expect($depo->bul('Sakarya Üniversitesi', 'docentlik', 'saglik')['anahtar'])
        ->toStartWith('sakarya-docent-2_3');

    // Yönergede karşılığı olmayan alanlar eşik üretmemeli.
    foreach (['filoloji', 'spor', 'ziraat'] as $alan) {
        expect($depo->bul('Sakarya Üniversitesi', 'docentlik', $alan))->toBeNull($alan);
    }
});

test('Anadolu toplam barajı iki gruba, alt barajı dört gruba ayırıyor', function () {
    $depo = sartDepo();

    // Toplam baraj: sosyal grubu 900, fen grubu 1500 (doçent).
    $toplam = function (string $alan) use ($depo): int {
        $esik = $depo->bul('Anadolu Üniversitesi', 'docentlik', $alan);

        return collect($esik['sart']['cocuklar'])
            ->first(fn (array $d) => ($d['rol'] ?? null) === 'toplam')['min_puan'];
    };

    expect($toplam('sosyal'))->toBe(900)
        ->and($toplam('hukuk'))->toBe(900)
        ->and($toplam('guzel_sanatlar'))->toBe(900)
        ->and($toplam('fen'))->toBe(1500);

    // Alt baraj aynı toplamda bile ayrışıyor: Hukuk 350, sosyal 150.
    $yayin = function (string $alan) use ($depo): int {
        $esik = $depo->bul('Anadolu Üniversitesi', 'docentlik', $alan);

        return collect($esik['sart']['cocuklar'])
            ->first(fn (array $d) => ($d['madde'] ?? null) === 'Ölçütler II · 1-2. madde')['min_puan'];
    };

    expect($yayin('sosyal'))->toBe(150)
        ->and($yayin('hukuk'))->toBe(350)
        ->and($yayin('fen'))->toBe(300);
});

test('Anadolu kadroya özgü koşullar doğru kadroda duruyor', function () {
    $depo = sartDepo();
    $madde = function (string $kadro, string $alan, string $m) use ($depo): bool {
        $esik = $depo->bul('Anadolu Üniversitesi', $kadro, $alan);

        return collect($esik['sart']['cocuklar'])->contains(fn (array $d) => ($d['madde'] ?? null) === $m);
    };

    // SCI şartı yönergede yalnız Dr. Öğr. Üyesi ilk atamada (Bölüm A/3-b).
    expect($madde('dr_ogr_uyesi', 'fen', 'Bölüm A/3-b'))->toBeTrue()
        ->and($madde('docentlik', 'fen', 'Bölüm A/3-b'))->toBeFalse()
        ->and($madde('profesorluk', 'fen', 'Bölüm A/3-b'))->toBeFalse();

    // Sanatsal etkinlik barajı yalnız Güzel Sanatlar'da ve Dr'da yok.
    expect($madde('docentlik', 'guzel_sanatlar', 'Ölçütler II · 28-40. madde'))->toBeTrue()
        ->and($madde('dr_ogr_uyesi', 'guzel_sanatlar', 'Ölçütler II · 28-40. madde'))->toBeFalse()
        ->and($madde('docentlik', 'sosyal', 'Ölçütler II · 28-40. madde'))->toBeFalse();
});

test('yazar sayısı katsayısı yalnızca bildiren cetvelde uygulanır', function () {
    $depo = sartDepo();
    $anadolu = $depo->katalog('anadolu-2023');

    $makale = function (?string $yazarlar): Faaliyet {
        $f = sartFaaliyet('SCIE/SSCI (Q1)', tarih: '2020-01-01');
        $f->yazarlar = $yazarlar;

        return $f;
    };

    // Ölçütler I/2: tek yazar tam puan, iki yazarlı 0,8; üç yazarlı 0,6;
    // dört ve üzeri 2,0/yazar sayısı. Madde 1'in ham puanı 150.
    expect($anadolu->puan($makale('A'), ['1']))->toBe(150)
        ->and($anadolu->puan($makale('A, B'), ['1']))->toBe(120)
        ->and($anadolu->puan($makale('A, B, C'), ['1']))->toBe(90)
        ->and($anadolu->puan($makale('A, B, C, D'), ['1']))->toBe(75)
        ->and($anadolu->puan($makale('A, B, C, D, E'), ['1']))->toBe(60);

    // Yazar listesi boşsa kaç kişi olduğunu bilmiyoruz; bir sayı varsaymak
    // veri uydurmak olurdu, çarpan uygulanmaz.
    expect($anadolu->puan($makale(null), ['1']))->toBe(150)
        ->and($anadolu->puan($makale('   '), ['1']))->toBe(150);

    // Kural bildirmeyen cetveller etkilenmemeli.
    $mersin = $depo->katalog('mersin-2024');
    $kodlar = array_keys($mersin->maddeler);

    expect($mersin->puan($makale('A, B, C, D'), $kodlar))
        ->toBe($mersin->puan($makale('A'), $kodlar));
});

test('yazar katsayısı toplam puana ve baraja da yansır', function () {
    $depo = sartDepo();
    $profil = new Profil(doktoraTarihi: Carbon::parse('2015-01-01'), yds: 70);
    $esik = $depo->bul('Anadolu Üniversitesi', 'dr_ogr_uyesi', 'sosyal');

    // Üç adet 150 puanlık Q1 makalesi tek yazarlıysa 450 puan (baraj 400 aşılır);
    // aynı makaleler dört yazarlıysa 3 × 75 = 225 ve baraj sağlanmaz.
    $uret = function (string $yazarlar) use ($profil, $depo, $esik): SartSonucu {
        $f = array_map(function () use ($yazarlar) {
            $x = sartFaaliyet('SCIE/SSCI (Q1)', tarih: '2020-01-01');
            $x->yazarlar = $yazarlar;

            return $x;
        }, range(1, 3));

        return collect($depo->degerlendir($esik, $f, $profil)->kosullar())
            ->first(fn (SartSonucu $k) => ($k->rol ?? null) === 'toplam');
    };

    expect($uret('A')->mevcut)->toBe(450)
        ->and($uret('A')->durum)->toBe(Durum::Saglandi)
        ->and($uret('A, B, C, D')->mevcut)->toBe(225)
        ->and($uret('A, B, C, D')->durum)->toBe(Durum::Saglanmadi);
});

test('yazar çarpanı role duyarlı yönergelerde sıraya göre değişiyor', function () {
    $depo = sartDepo();
    $yazarlar = fn (int $n) => implode(', ', array_map(fn (int $i) => "Y{$i}", range(1, $n)));

    $carpan = function (string $cetvel, string $rol, int $n, string $kategori = 'makale') use ($depo, $yazarlar): float {
        $f = sartFaaliyet($kategori === 'atif' ? 'WoS / Scopus' : 'SCIE/SSCI (Q1)', tarih: '2020-01-01');
        $f->kategori = Kategori::from($kategori);
        $f->rol = $rol;
        $f->yazarlar = $yazarlar($n);

        return $depo->katalog($cetvel)->yazarCarpani($f);
    };

    // Kocaeli Tablo 1, yönergenin kendi örneği: 30 puanlık dört yazarlı yayında
    // 1. yazar 21 (0,70), 2. yazar 18 (0,60), 3. yazar 15 (0,50), 4. yazar 12 (0,40).
    expect($carpan('kocaeli-2023', 'ilk', 4))->toBe(0.70)
        ->and($carpan('kocaeli-2023', 'yazar_2', 4))->toBe(0.60)
        ->and($carpan('kocaeli-2023', 'yazar_3', 4))->toBe(0.50)
        ->and($carpan('kocaeli-2023', 'yazar_4', 4))->toBe(0.40)
        ->and($carpan('kocaeli-2023', 'ilk', 8))->toBe(0.50)
        ->and($carpan('kocaeli-2023', 'yazar_6', 8))->toBe(0.20);

    // Sırası belirtilmemiş ortak yazara o sütunun en düşük satırı verilir.
    expect($carpan('kocaeli-2023', 'ortak', 4))->toBe(0.40);

    // Sıra bazlı roller, kuralı sıraya göre yazmayan yönergelerde 'ortak'
    // satırına düşer: Çukurova'da 2. yazar da diğer yazarlarla aynı çarpanı alır.
    expect($carpan('cukurova-2024', 'yazar_2', 3))->toBe(0.4);

    // Çukurova: n>2'de başlıca yazar 0,5; diğerleri 0,8/(n-1). Hiçbir yazar
    // tek yazarlı puanın %10'undan azını almaz.
    expect($carpan('cukurova-2024', 'baslica', 3))->toBe(0.5)
        ->and($carpan('cukurova-2024', 'ortak', 3))->toBe(0.4)
        ->and($carpan('cukurova-2024', 'ortak', 2))->toBe(0.5)
        ->and($carpan('cukurova-2024', 'ortak', 20))->toBe(0.10);

    // Selçuk: başlıca yazar yarısını alır, diğerleri kalan yarıyı paylaşır;
    // atıflarda yazar sayısına bakılmaz.
    expect($carpan('selcuk-2024-egitim', 'baslica', 4))->toBe(0.5)
        ->and(round($carpan('selcuk-2024-egitim', 'ortak', 4), 3))->toBe(0.167)
        ->and($carpan('selcuk-2024-egitim', 'ortak', 4, 'atif'))->toBe(1.0);
});

test('rol belirtilmemişse ortak yazar varsayılır', function () {
    $depo = sartDepo();

    // Sırayı bilmeden yüksek satırı vermek adayın puanını fazla gösterirdi.
    $f = sartFaaliyet('SCIE/SSCI (Q1)', tarih: '2020-01-01');
    $f->yazarlar = 'A, B, C, D';
    $f->rol = null;

    expect($depo->katalog('kocaeli-2023')->yazarCarpani($f))->toBe(0.40);
});

test('Fırat çeyreklikleri alt maddelere bölüyor ve aralık grupları hepsini kapsıyor', function () {
    $katalog = sartDepo()->katalog('firat-2026');

    // EK-1 A2.1 puanı tek satırda "Q1 200 / Q2 160 / Q3 120 / Q4 80" veriyor;
    // kaynak sözlüğü çeyrekliği ayırdığı için satır alt maddelere bölündü.
    expect($katalog->maddePuani('A2.1-Q1'))->toBe(200)
        ->and($katalog->maddePuani('A2.1-Q4'))->toBe(80)
        ->and($katalog->maddePuani('A2.2-Q1'))->toBe(60);

    // Koşullar "A2.1-A2.2" gibi aralığa atıf yapıyor; grup bölünmüş kodların
    // tamamını yakalamalı, yoksa baraj sessizce eksik puanlanır.
    expect($katalog->coz(['A2.1-A2.2']))->toHaveCount(8)
        ->and($katalog->coz(['A2.1']))->toHaveCount(4);
});

test('Fırat alan grupları üç ayrı desene ayrılıyor', function () {
    $depo = sartDepo();

    $madde = function (string $alan, string $m): bool {
        $esik = sartDepo()->bul('Fırat Üniversitesi', 'dr_ogr_uyesi', $alan);

        return collect($esik['sart']['cocuklar'])->contains(fn (array $d) => ($d['madde'] ?? null) === $m);
    };

    // Sağlık/mühendislik/fen WoS makale sayısı istiyor; sosyal grubu istemiyor.
    expect($madde('muhendislik', 'Madde 10 · a.1'))->toBeTrue()
        ->and($madde('sosyal', 'Madde 10 · a.1'))->toBeFalse()
        ->and($madde('sosyal', 'Madde 10 · ç.1'))->toBeTrue();

    // Toplam baraj güzel sanatlarda düşük: yönergede 500 ↔ diğer alanlarda
    // 1000. Mutlak değer GEÇİŞ ORANIYLA ölçekleniyor (geçici madde 14), o
    // yüzden burada ORAN korunuyor mu diye bakılıyor; oranın kendisi ayrı
    // testte doğrulanıyor.
    $toplam = function (string $alan) use ($depo): int {
        $esik = $depo->bul('Fırat Üniversitesi', 'dr_ogr_uyesi', $alan);

        return collect($esik['sart']['cocuklar'])
            ->first(fn (array $d) => ($d['rol'] ?? null) === 'toplam')['min_puan'];
    };

    expect($toplam('muhendislik'))->toBe($toplam('guzel_sanatlar') * 2);
});

test('Gaziantep proje puanını göreve göre oranlıyor', function () {
    $katalog = sartDepo()->katalog('gaziantep-2026');

    // Yönerge: koordinatör/yürütücü %100, araştırmacı/uzman %60,
    // danışman/bursiyer %20. Motorda ayrı çarpan yok; oran madde puanına
    // gömülü ve `roller` filtresi hangi maddenin uygulanacağını belirliyor.
    $puan = function (string $rol) use ($katalog): int {
        $f = sartFaaliyet('Diğer Uluslararası Fon', tarih: '2020-01-01');
        $f->kategori = Kategori::Proje;
        $f->rol = $rol;

        return $katalog->puan($f, array_keys($katalog->maddeler));
    };

    expect($puan('yurutucu'))->toBe(150)
        ->and($puan('arastirmaci'))->toBe(90)
        ->and($puan('bursiyer'))->toBe(30);

    // "5 nolu maddeden (BAP hariç)" kümesi BAP kalemlerini dışarıda bırakmalı.
    expect($katalog->coz(['5-BAP-haric']))->not->toContain('5-bap-y');
});

test('Gaziantep dört bilim alanının makale barajını farklı kuruyor', function () {
    $depo = sartDepo();

    $baraj = function (string $alan, string $madde) use ($depo): ?int {
        $esik = $depo->bul('Gaziantep Üniversitesi', 'dr_ogr_uyesi', $alan);
        $bul = function (array $d) use (&$bul, $madde): ?int {
            if (($d['madde'] ?? null) === $madde) {
                return $d['min_puan'] ?? null;
            }
            foreach ($d['cocuklar'] ?? [] as $c) {
                if (($s = $bul($c)) !== null) {
                    return $s;
                }
            }

            return null;
        };

        return $bul($esik['sart']);
    };

    // Fen 1(a)'dan 120, sağlık aynı maddeden 60 istiyor.
    expect($baraj('muhendislik', 'MADDE 12/1'))->toBe(120)
        ->and($baraj('saglik', 'MADDE 13/1'))->toBe(60);

    // Sosyal'de makale koşulu iki seçenekli (dar kümeden 75 ya da tümünden 90).
    expect($baraj('sosyal', 'MADDE 14/1-a'))->toBe(75);

    // Mimarlık/güzel sanatlar en geniş kümeden en düşük barajı koyuyor.
    expect($baraj('guzel_sanatlar', 'MADDE 15/1-a'))->toBe(45);
});

test('SUBÜ alternatifli koşulda tek dalın sağlanması yeterli', function () {
    $depo = sartDepo();
    $profil = new Profil(doktoraTarihi: Carbon::parse('2015-01-01'), yds: 70);
    $esik = $depo->bul('Sakarya Uygulamalı Bilimler Üniversitesi', 'dr_ogr_uyesi', 'muhendislik');

    // Yönerge "aşağıdaki faaliyetlerden BİRİNİ gerçekleştirmek" diyor; iki WoS
    // makalesi ilk seçeneği tek başına karşılar.
    $iki = array_map(fn () => sartFaaliyet('SCIE/SSCI (Q1)', tarih: '2020-01-01'), range(1, 2));
    $secenek = fn (array $f) => collect($depo->degerlendir($esik, $f, $profil)->kosullar())
        ->first(fn (SartSonucu $k) => str_contains($k->aciklama, 'seçeneklerden birini'));

    expect($secenek($iki)->durum)->toBe(Durum::Saglandi);

    // Tek WoS makalesi hiçbir seçeneği tamamlamıyor.
    expect($secenek([$iki[0]])->durum)->toBe(Durum::Saglanmadi);
});

test('SUBÜ iki alan grubunun eşik kümesi bir kademe farklı', function () {
    $depo = sartDepo();

    $ilkSecenek = function (string $alan) use ($depo): array {
        $esik = $depo->bul('Sakarya Uygulamalı Bilimler Üniversitesi', 'dr_ogr_uyesi', $alan);
        $veya = collect($esik['sart']['cocuklar'])
            ->first(fn (array $d) => ($d['tip'] ?? null) === 'veya');

        return $veya['cocuklar'][0];
    };

    // Mühendislik grubunda ilk seçenek iki WoS yayını, sosyal grupta bir tane.
    expect($ilkSecenek('muhendislik')['min_adet'])->toBe(2)
        ->and($ilkSecenek('sosyal')['min_adet'])->toBe(1);
});

test('GİBTÜ fen ve sosyal alanların makale kümesi farklı genişlikte', function () {
    $depo = sartDepo();

    // Madde 11/12 "1.a veya 1.b" (yalnızca WoS ve ESCI) derken, Madde 13/14/15
    // "1 numaralı madde" diyor ve TR Dizin ile ulusal hakemli dergileri de sayıyor.
    $trDizin = fn () => sartFaaliyet('TR Dizin', tarih: '2020-01-01');
    $profil = new Profil(doktoraTarihi: Carbon::parse('2015-01-01'), yds: 70);

    $makalePuani = function (string $alan) use ($depo, $trDizin, $profil): int {
        $esik = $depo->bul('Gaziantep İslam Bilim ve Teknoloji Üniversitesi', 'dr_ogr_uyesi', $alan);

        return collect($depo->degerlendir($esik, [$trDizin()], $profil)->kosullar())
            ->first(fn (SartSonucu $k) => str_ends_with((string) $k->madde, '/A.1'))->mevcut;
    };

    expect($makalePuani('fen'))->toBe(0)
        ->and($makalePuani('sosyal'))->toBe(20);
});

test('GİBTÜ profesörlükte doçentlik öncesi ve sonrası iki ayrı toplam istiyor', function () {
    $depo = sartDepo();
    $esik = $depo->bul('Gaziantep İslam Bilim ve Teknoloji Üniversitesi', 'profesorluk', 'fen');

    $toplamlar = collect($esik['sart']['cocuklar'])
        ->filter(fn (array $d) => ($d['rol'] ?? null) === 'toplam')
        ->map(fn (array $d) => [$d['min_puan'], isset($d['donem'])])
        ->values()->all();

    // Genel toplam 200 (dönemsiz), doçentlik sonrası 100 (dönemli).
    expect($toplamlar)->toBe([[200, false], [100, true]]);
});

test('OMÜ kategori aralığının üst sınırı alan grubuna göre değişiyor', function () {
    $depo = sartDepo();

    // Yönergenin en kolay yanlış okunan yeri: hepsi "1-10" ile başlıyor ama
    // ikinci baraj A'da 1-14, B'de 1-15, C'de 1-16 kategorilerinden.
    $ikinci = function (string $alan) use ($depo): array {
        $esik = $depo->bul('Ondokuz Mayıs Üniversitesi', 'docentlik', $alan);
        $d = collect($esik['sart']['cocuklar'])
            ->first(fn (array $x) => str_contains((string) ($x['madde'] ?? ''), 'Madde 12 · 1-1')
                && ! str_contains((string) $x['madde'], '1-10'));

        return [$d['maddeler'][0], $d['min_puan']];
    };

    expect($ikinci('fen'))->toBe(['1-14', 750])
        ->and($ikinci('hukuk'))->toBe(['1-15', 500])
        ->and($ikinci('guzel_sanatlar'))->toBe(['1-16', 500]);

    // Yalnızca C temel alanında ayrıca 16. kategori (sanatsal etkinlik) barajı var.
    $sanat = function (string $alan) use ($depo): bool {
        $esik = $depo->bul('Ondokuz Mayıs Üniversitesi', 'docentlik', $alan);

        return collect($esik['sart']['cocuklar'])
            ->contains(fn (array $x) => ($x['madde'] ?? null) === 'Madde 12 · 16');
    };

    expect($sanat('guzel_sanatlar'))->toBeTrue()
        ->and($sanat('fen'))->toBeFalse();
});

test('OMÜ profesörlükte toplamın bir kısmını doçentlik sonrasına bağlıyor', function () {
    $depo = sartDepo();
    $esik = $depo->bul('Ondokuz Mayıs Üniversitesi', 'profesorluk', 'fen');

    $bul = fn (string $m) => collect($esik['sart']['cocuklar'])
        ->first(fn (array $x) => ($x['madde'] ?? null) === $m);

    // 1-10 kategorilerinden 720 puan, bunun en az 360'ı doçentlik sonrası.
    expect($bul('Madde 13 · 1-10')['min_puan'])->toBe(720)
        ->and(isset($bul('Madde 13 · 1-10')['donem']))->toBeFalse()
        ->and($bul('Madde 13 · 1-10 (dönem)')['min_puan'])->toBe(360)
        ->and(isset($bul('Madde 13 · 1-10 (dönem)')['donem']))->toBeTrue();
});

test('Adıyaman yazar sırasına göre puanı azaltıyor', function () {
    $katalog = sartDepo()->katalog('adiyaman-2024');

    // Tablo 1: 1. isim tek yazarlıda %100, üç yazarlıda %80; 2. isim üç
    // yazarlıda %70, 3. isim %60. Sorumlu yazar birinci isim gibi sayılıyor.
    $puan = function (string $rol, int $n) use ($katalog): int {
        $f = sartFaaliyet('SCIE/SSCI (Q1)', tarih: '2020-01-01');
        $f->rol = $rol;
        $f->yazarlar = implode(', ', array_map(fn (int $i) => "Y{$i}", range(1, $n)));

        return $katalog->puan($f, ['A.1']);
    };

    // A.1 ham puanı 150.
    expect($puan('tek', 1))->toBe(150)
        ->and($puan('ilk', 3))->toBe(120)
        ->and($puan('baslica', 3))->toBe(120)
        ->and($puan('yazar_2', 3))->toBe(105)
        ->and($puan('yazar_3', 3))->toBe(90);
});

test('Adıyaman doçentlikte puan barajı aramıyor', function () {
    $depo = sartDepo();

    // Yönerge doçentlik için kendi puan tablosunu uygulamıyor (Madde 21);
    // eksik veri değil, kasıtlı. Dr ve profesörde baraj var.
    $barajVar = function (string $kadro) use ($depo): bool {
        $esik = $depo->bul('Adıyaman Üniversitesi', $kadro, 'fen');

        return collect($esik['sart']['cocuklar'])
            ->contains(fn (array $d) => ($d['tip'] ?? null) === 'puan');
    };

    expect($barajVar('dr_ogr_uyesi'))->toBeTrue()
        ->and($barajVar('profesorluk'))->toBeTrue()
        ->and($barajVar('docentlik'))->toBeFalse();
});

test('Batman kendi cetveli olmadan ÜAK tablolarını kullanıyor', function () {
    $depo = sartDepo();

    // Yönergenin puan cetveli yok; koşullar "ÜAK Doçentlik Şartlarında
    // belirtilen faaliyetlerden en az 30 puan" diyor. Cetvel alan başına
    // ÜAK tablosuna çözülmeli.
    foreach (['fen', 'sosyal', 'guzel_sanatlar'] as $alan) {
        $esik = $depo->bul('Batman Üniversitesi', 'dr_ogr_uyesi', $alan);
        expect($esik['cetvel'])->toBe("uak-2024-mart-{$alan}")
            ->and($depo->katalog($esik['cetvel']))->not->toBeNull();
    }

    // Dr'da alan grubuna göre makale koşulu değişiyor, doçentte hiç baraj yok.
    $puanDugumu = function (string $kadro, string $alan) use ($depo): int {
        $esik = $depo->bul('Batman Üniversitesi', $kadro, $alan);

        return collect($esik['sart']['cocuklar'])
            ->filter(fn (array $d) => in_array($d['tip'] ?? null, ['puan', 'adet', 'veya'], true))
            ->count();
    };

    expect($puanDugumu('dr_ogr_uyesi', 'fen'))->toBeGreaterThan(0)
        ->and($puanDugumu('docentlik', 'fen'))->toBe(0);
});

test('Amasya yazar çarpanını yalnızca makale, kongre ve atıfta uyguluyor', function () {
    $katalog = sartDepo()->katalog('amasya-2024');

    // Çizelge 2 yalnızca "Makale, Kongre ve Atıf Alanındaki Eserler" için.
    // Kitapta yönerge kendi kuralını yazıyor: "kitabın toplam puanı yazar
    // SIRALAMASINA BAKILMAKSIZIN yazar sayısına bölünür" — düz 1/n, sıra
    // sayılmaz. Projede ise bölme yok, "araştırmacıların her birine" sabit
    // puan veriliyor.
    $carpan = function (string $kategori, string $kaynak) use ($katalog): float {
        $f = sartFaaliyet($kaynak, tarih: '2020-01-01');
        $f->kategori = Kategori::from($kategori);
        $f->rol = 'yazar_3';
        $f->yazarlar = 'A, B, C, D';

        return $katalog->yazarCarpani($f);
    };

    expect($carpan('makale', 'SCIE/SSCI (Q1)'))->toBe(0.65)
        ->and($carpan('atif', 'WoS / Scopus'))->toBe(0.65)
        // Dört yazarlı kitap: 1/4. Sıra ('yazar_3') hiç sayılmıyor.
        ->and($carpan('kitap', 'BKCI / Scopus Kitap'))->toBe(0.25)
        ->and($carpan('proje', 'TÜBİTAK'))->toBe(1.0);
});

test('Amasya profesörlükte beş alan grubunu farklı barajlıyor', function () {
    $depo = sartDepo();

    $alt = function (string $alan) use ($depo): int {
        $esik = $depo->bul('Amasya Üniversitesi', 'profesorluk', $alan);

        return collect($esik['sart']['cocuklar'])
            ->first(fn (array $d) => ($d['madde'] ?? null) === 'Madde 9')['min_puan'];
    };

    expect($alt('muhendislik'))->toBe(150)
        ->and($alt('saglik'))->toBe(100)
        ->and($alt('hukuk'))->toBe(125)
        ->and($alt('egitim'))->toBe(125);

    // Eğitim "tek yazarlı", mühendislik "başlıca yazar" istiyor — farklı filtre.
    $yazar = function (string $alan, string $madde) use ($depo): ?string {
        $esik = $depo->bul('Amasya Üniversitesi', 'profesorluk', $alan);

        return collect($esik['sart']['cocuklar'])
            ->first(fn (array $d) => ($d['madde'] ?? null) === $madde)['yazar'] ?? null;
    };

    expect($yazar('muhendislik', 'Madde 9/a-1'))->toBe('baslica')
        ->and($yazar('egitim', 'Madde 9/ç-1'))->toBe('tek');
});

test('Ağrı formül tabanlı yazar kuralını uyguluyor ve çarpan 1 ü aşmıyor', function () {
    $katalog = sartDepo()->katalog('agri-2024');

    $carpan = function (string $rol, int $n) use ($katalog): float {
        $f = sartFaaliyet('SCIE/SSCI (Q1)', tarih: '2020-01-01');
        $f->rol = $rol;
        $f->yazarlar = implode(', ', array_map(fn (int $i) => "Y{$i}", range(1, $n)));

        return round($katalog->yazarCarpani($f), 3);
    };

    // Madde 4.2: 1. isim Puan/n + Puan×0,30 → üç yazarlıda 1/3 + 0,30 = 0,633.
    expect($carpan('ilk', 3))->toBe(0.633)
        ->and($carpan('yazar_2', 3))->toBe(0.533)
        ->and($carpan('yazar_5', 5))->toBe(0.200);

    // Madde 4.1: tek isim tam puan. Formül uygulansa 1,30 çıkardı.
    expect($carpan('tek', 1))->toBe(1.0)
        ->and($carpan('ilk', 1))->toBe(1.0);

    // Tutarsız veri (tek yazarlı eserde "2. isim") çarpanı 1'in ÜSTÜNE
    // çıkarıyordu, yani puanı artırıyordu. Üst sınır motorda.
    expect($carpan('yazar_2', 1))->toBe(1.0);
});

test('Ağrı sağlıkta alt baraj aramıyor, sosyalde kitap barajı ekliyor', function () {
    $depo = sartDepo();

    $barajlar = function (string $kadro, string $alan) use ($depo): array {
        $esik = $depo->bul('Ağrı İbrahim Çeçen Üniversitesi', $kadro, $alan);

        return collect($esik['sart']['cocuklar'])
            ->filter(fn (array $d) => ($d['tip'] ?? null) === 'puan' && ($d['rol'] ?? null) !== 'toplam')
            ->pluck('min_puan')->values()->all();
    };

    // Madde 5.1.3: sağlıkta yalnızca genel toplam var, alt baraj yok.
    expect($barajlar('dr_ogr_uyesi', 'saglik'))->toBe([])
        ->and($barajlar('dr_ogr_uyesi', 'fen'))->toBe([20]);

    // Madde 7.1.2: sosyal profesörlükte kitaptan ayrı 30 puan barajı var.
    expect($barajlar('profesorluk', 'sosyal'))->toContain(30)
        ->and($barajlar('profesorluk', 'fen'))->not->toContain(30);
});

test('Artvin yayın türüne göre farklı puan veriyor ve grup tavanı uyguluyor', function () {
    $katalog = sartDepo()->katalog('artvin-2024');

    // Yönerge A1-A3 dergilerinde derleme için puanın YARISI, vaka/teknik not
    // için ÜÇTE BİRİ diyor; motorda tür çarpanı yok, puanlar önceden bölündü.
    $puan = function (string $tur) use ($katalog): int {
        $f = sartFaaliyet('SCIE/SSCI (Q1)', tarih: '2020-01-01');
        $f->yayin_turu = $tur;

        return $katalog->puan($f, array_keys($katalog->maddeler));
    };

    expect($puan('ozgun_makale'))->toBe(60)
        ->and($puan('derleme'))->toBe(15)
        ->and($puan('vaka_teknik_not'))->toBe(10);

    // Yönergenin kendi üst sınırları: bildiri 50, kitap 80, atıf 100.
    $cokBildiri = array_map(
        fn () => sartFaaliyet('Uluslararası Tam Metin (CPCI)', kategori: Kategori::Bildiri, tarih: '2020-01-01'),
        range(1, 10),
    );

    // 10 × 13 = 130 ham puan, tavan 50.
    expect($katalog->topla($cokBildiri, array_keys($katalog->maddeler)))->toBe(50);
});

test('Artvin profesörlükte dört alan grubunu farklı kuruyor', function () {
    $depo = sartDepo();

    $maddeler = function (string $alan) use ($depo): array {
        $esik = $depo->bul('Artvin Çoruh Üniversitesi', 'profesorluk', $alan);

        return collect($esik['sart']['cocuklar'])->pluck('madde')->filter()->values()->all();
    };

    // Mimarlık grubunda proje koşulu yok, diğer üçünde var.
    expect($maddeler('muhendislik'))->toContain('Madde 9/a-5')
        ->and($maddeler('sosyal'))->toContain('Madde 9/c-5')
        ->and($maddeler('mimarlik'))->not->toContain('Madde 9/b-5');

    // Eğitim'de makale SAYISI ayrıca şart (9/ç-3), diğerlerinde yok.
    expect($maddeler('egitim'))->toContain('Madde 9/ç-3');
});

test('Trabzon: ikinci %30 eksikse açığın iki katı yayınlardan isteniyor', function () {
    $depo = sartDepo();
    $esik = $depo->bul('Trabzon Üniversitesi', 'docentlik', 'sosyal');
    $ad = 'Ödül, proje ve patent kalemlerinizden en az 12 puan';
    $profil = new Profil(doktoraTarihi: Carbon::parse('2018-01-01'));

    // Uluslararası indeksli makale 8 puan; ödül-proje-patent hanesi boş.
    $makale = fn () => sartFaaliyet('SCIE/SSCI (Q1)', tarih: '2024-01-01');
    $odul = fn () => sartFaaliyet('Ulusal Bilim/Sanat Ödülü', Kategori::Odul, null, '2024-01-01');

    // Dört makale = 32 puan. Açık 12; telafi 12 taban + 12 × 2 = 36 istiyor.
    $az = sartDugum($depo->degerlendir($esik, [$makale(), $makale(), $makale(), $makale()], $profil), $ad);

    expect($az->mevcut)->toBe(0)
        ->and($az->telafi->gerekli)->toBe(36)
        ->and($az->telafi->mevcut)->toBe(32)
        ->and($az->durum)->toBe(Durum::Saglanmadi);

    // Altı makale = 48 puan: aynı açık, aynı 36 puanlık telafi, bu kez karşılanıyor.
    $yeter = sartDugum(
        $depo->degerlendir($esik, array_map($makale, range(1, 6)), $profil), $ad,
    );

    expect($yeter->durum)->toBe(Durum::Saglandi)
        ->and($yeter->telafiIleSaglandi())->toBeTrue();

    // Ödül açığı küçülünce telafi de küçülüyor: 10 puanlık ödülle açık 2'ye
    // düşer, telafi 12 + 2 × 2 = 16 ister ve dört makale yeter.
    $kismi = sartDugum($depo->degerlendir($esik, [$odul(), $makale(), $makale(), $makale(), $makale()], $profil), $ad);

    expect($kismi->mevcut)->toBe(10)
        ->and($kismi->telafi->gerekli)->toBe(16)
        ->and($kismi->durum)->toBe(Durum::Saglandi);

    // Ödül tek başına barajı geçerse telafi hiç devreye girmez.
    $tam = sartDugum($depo->degerlendir($esik, [$odul(), $odul()], $profil), $ad);

    expect($tam->mevcut)->toBe(20)
        ->and($tam->telafiIleSaglandi())->toBeFalse();
});

test('Trabzon barajı temel alana değil birime bağlı', function () {
    $depo = sartDepo();

    $gerekli = function (string $kadro, string $alan, ?string $birim = null) use ($depo): int {
        $esik = $depo->bul('Trabzon Üniversitesi', $kadro, $alan, $birim);

        return collect($esik['sart']['cocuklar'])->firstWhere('rol', 'toplam')['min_puan'];
    };

    // Dr. Öğr. Üyeliğinde bütün birimler aynı: 10 puan.
    expect($gerekli('dr_ogr_uyesi', 'sosyal'))->toBe(10)
        ->and($gerekli('dr_ogr_uyesi', 'hukuk'))->toBe(10)
        ->and($gerekli('dr_ogr_uyesi', 'guzel_sanatlar'))->toBe(10);

    // Doçent ve profesörlükte Hukuk düşük barajlı.
    expect($gerekli('docentlik', 'sosyal'))->toBe(40)
        ->and($gerekli('docentlik', 'hukuk'))->toBe(28)
        ->and($gerekli('profesorluk', 'sosyal'))->toBe(60)
        ->and($gerekli('profesorluk', 'hukuk'))->toBe(42);

    // Aynı temel alanın iki birimi farklı baraja tabi; birim seçilmeden eşik
    // bulunamaz, çünkü hangisinin doğru olduğu bilinemez.
    expect($gerekli('docentlik', 'guzel_sanatlar', 'Güzel Sanatlar Fakültesi'))->toBe(28)
        ->and($gerekli('docentlik', 'guzel_sanatlar', 'Devlet Konservatuvarı'))->toBe(40)
        ->and($depo->bul('Trabzon Üniversitesi', 'docentlik', 'guzel_sanatlar'))->toBeNull();
});

test('Trabzon yazar çarpanı sıra ve sayı matrisini birlikte uyguluyor', function () {
    $katalog = sartDepo()->katalog('trabzon-2025');
    $kodlar = array_keys($katalog->maddeler);

    $puan = function (?string $rol, int $yazarSayisi) use ($katalog, $kodlar): int {
        $f = sartFaaliyet('SCIE/SSCI (Q1)', yazarRolu: $rol);           // 1.1.1.1 → 8 puan
        $f->yazarlar = implode(', ', array_map(fn ($i) => "Yazar {$i}", range(1, $yazarSayisi)));

        return $katalog->puan($f, $kodlar);
    };

    // 1. isim: üç yazarlıda 0,90 → 7; altı yazarlıda 0,75 → 6.
    expect($puan('ilk', 3))->toBe(7)
        ->and($puan('ilk', 6))->toBe(6);

    // 3. isim üç yazarlıda 0,75 → 6; dört yazarlıda 0,70 → 5.
    expect($puan('yazar_3', 3))->toBe(6)
        ->and($puan('yazar_3', 4))->toBe(5);

    // "6. yazar veya sonrası" 6-8 yazarlı eserde zorunlu olarak 0,35 satırında
    // (→ 2); dokuz ve üzeri yazarda 0,25 olabileceği için düşük satır alınır.
    expect($puan('yazar_6', 7))->toBe(2)
        ->and($puan('yazar_6', 9))->toBe(2);

    // Sırasını belirtmeyen ve "başlıca yazar" diyen aday, o yazar sayısındaki
    // en düşük satırı alır: yönergenin Tablo 3'ü sorumlu yazara ayrıcalık
    // tanımıyor, sıra bilinmeden yüksek satır verilemez.
    expect($puan('ortak', 3))->toBe(6)
        ->and($puan('baslica', 3))->toBe(6);

    // Yazar listesi boşsa çarpan hiç uygulanmaz.
    expect($puan('ortak', 1))->toBe(8);
});

test('Iğdır altı ve daha fazla yazarlı yayında formül tabanlı çarpana geçiyor', function () {
    $katalog = sartDepo()->katalog('igdir-2023');
    $kodlar = array_keys($katalog->maddeler);

    $puan = function (?string $rol, int $yazarSayisi) use ($katalog, $kodlar): int {
        $f = sartFaaliyet('SCIE/SSCI (Q1)', yazarRolu: $rol);          // 1.a.1 → 100 puan
        $f->yazarlar = implode(', ', array_map(fn ($i) => "Yazar {$i}", range(1, $yazarSayisi)));

        return $katalog->puan($f, $kodlar);
    };

    // Beş yazara kadar yönergenin matrisi.
    expect($puan('ilk', 3))->toBe(80)
        ->and($puan('yazar_3', 3))->toBe(60)
        ->and($puan('yazar_5', 5))->toBe(30);

    // Altı yazardan itibaren formül: ilk isim = Puan × 1,2 / yazar sayısı.
    expect($puan('ilk', 6))->toBe(20)
        ->and($puan('ilk', 8))->toBe(15);

    // Diğer yazarlar = (Puan − ilk ismin puanı) / diğer yazar sayısı. Altı
    // yazarlıda formülün kendisi de 0,8/(n−1) de 16 veriyor; daha kalabalık
    // yayınlarda bizimki bir tık DÜŞÜK kalıyor (8 yazarlıda 11'e karşı 12).
    expect($puan('yazar_3', 6))->toBe(16)
        ->and($puan('yazar_3', 8))->toBe(11);

    // Sorumlu yazar yönergede birinci isimle aynı; sıra belirtmeyen aday o
    // yazar sayısındaki en düşük satırı alır.
    expect($puan('baslica', 3))->toBe(80)
        ->and($puan('ortak', 3))->toBe(60);
});

test('Iğdır yalnızca yönergenin adıyla andığı dört alan grubunu kapsıyor', function () {
    $depo = sartDepo();

    $var = fn (string $alan): bool => $depo->bul('Iğdır Üniversitesi', 'docentlik', $alan) !== null;

    // Yönergenin saydığı gruplar: Fen ve Sağlık, Sosyal, Güzel Sanatlar, Spor.
    expect($var('fen'))->toBeTrue()
        ->and($var('saglik'))->toBeTrue()
        ->and($var('sosyal'))->toBeTrue()
        ->and($var('guzel_sanatlar'))->toBeTrue()
        ->and($var('spor'))->toBeTrue();

    // Yönerge bunlardan hiç söz etmiyor; "Fen ve Sağlık" grubuna katmak adaya
    // yazmayan bir baraj göstermek olurdu.
    expect($var('muhendislik'))->toBeFalse()
        ->and($var('ziraat'))->toBeFalse()
        ->and($var('egitim'))->toBeFalse()
        ->and($var('hukuk'))->toBeFalse();
});

test('Iğdır alana göre farklı kapı kuruyor: sayı, kitap ya da alt baraj', function () {
    $depo = sartDepo();
    $profil = new Profil(doktoraTarihi: Carbon::parse('2018-01-01'));

    $q1 = fn () => sartFaaliyet('SCIE/SSCI (Q1)', tarih: '2022-01-01');
    $sergi = fn () => sartFaaliyet('Kişisel Etkinlik (Uluslararası)', Kategori::SanatselEtkinlik, null, '2022-01-01');

    // Fen: altı SCI makale isteniyor, beşi yetmiyor.
    $fen = $depo->bul('Iğdır Üniversitesi', 'docentlik', 'fen');
    $bes = sartDugum($depo->degerlendir($fen, array_map($q1, range(1, 5)), $profil), 'B-3/a');
    $alti = sartDugum($depo->degerlendir($fen, array_map($q1, range(1, 6)), $profil), 'B-3/a');

    expect($bes->durum)->toBe(Durum::Saglanmadi)
        ->and($alti->durum)->toBe(Durum::Saglandi);

    // Sosyal aynı kadroda tek Q1 makaleyle alana özgü koşulu geçiyor.
    $sosyal = $depo->bul('Iğdır Üniversitesi', 'docentlik', 'sosyal');
    expect(sartDugum($depo->degerlendir($sosyal, [$q1()], $profil), 'B-3/b')->durum)
        ->toBe(Durum::Saglandi);

    // Güzel Sanatlar'da koşul makale değil, sanat etkinliklerinden 600 puanlık
    // alt baraj: altı uluslararası kişisel etkinlik (6 × 100) tam karşılıyor.
    $gs = $depo->bul('Iğdır Üniversitesi', 'docentlik', 'guzel_sanatlar');
    $az = sartDugum($depo->degerlendir($gs, array_map($sergi, range(1, 5)), $profil), 'B-3/c');
    $tam = sartDugum($depo->degerlendir($gs, array_map($sergi, range(1, 6)), $profil), 'B-3/c');

    expect($az->mevcut)->toBe(500)
        ->and($az->durum)->toBe(Durum::Saglanmadi)
        ->and($tam->mevcut)->toBe(600)
        ->and($tam->durum)->toBe(Durum::Saglandi);
});

test('İnönü aynı temel alanı iki birime ayırıyor', function () {
    $depo = sartDepo();
    $tip = 'Tıp ve Diş Hekimliği Fakülteleri';
    $saglik = 'Sağlık Bilimleri, Hemşirelik ve Eczacılık Fakülteleri';

    $toplam = function (string $kadro, ?string $birim) use ($depo): ?int {
        $esik = $depo->bul('İnönü Üniversitesi', $kadro, 'saglik', $birim);

        return $esik === null
            ? null
            : collect($esik['sart']['cocuklar'])->firstWhere('rol', 'toplam')['min_puan'];
    };

    // Yönerge Tıp/Diş ile Sağlık Bilimlerini ayrı sütunlarda tutuyor.
    expect($toplam('dr_ogr_uyesi', $tip))->toBe(500)
        ->and($toplam('dr_ogr_uyesi', $saglik))->toBe(700)
        ->and($toplam('profesorluk', $tip))->toBe(2500)
        ->and($toplam('profesorluk', $saglik))->toBe(3000);

    // Birim seçilmeden hangisinin geçerli olduğu bilinemez.
    expect($toplam('docentlik', null))->toBeNull();

    // İlahiyat kendi sütununda değil; yönerge onu sosyal alanın içinde sayıyor.
    expect($depo->bul('İnönü Üniversitesi', 'docentlik', 'ilahiyat')['anahtar'])
        ->toBe('inonu-sosyal-docent-ilahiyat');

    // Ziraat Madde 4'ün saydığı on bir alanda yok.
    expect($depo->bul('İnönü Üniversitesi', 'docentlik', 'ziraat'))->toBeNull();
});

test('İnönü ek koşul bloğu alternatiflerden biriyle sağlanıyor', function () {
    $depo = sartDepo();
    $esik = $depo->bul('İnönü Üniversitesi', 'docentlik', 'fen');
    $ad = 'Ek koşullardan en az biri sağlanmalı';

    // Hiçbir alternatif sağlanmıyor ama FWCI ve iş birliği dalları BEYAN:
    // motor kesin ret vermemeli, belirsiz kalmalı.
    $bos = sartDugum($depo->degerlendir($esik, [], new Profil), $ad);
    expect($bos->durum)->toBe(Durum::Belirsiz);

    // h-indeksi 7'ye ulaşınca blok sağlanır.
    $hIndeks = sartDugum($depo->degerlendir($esik, [], new Profil(hIndeksi: 7)), $ad);
    expect($hIndeks->durum)->toBe(Durum::Saglandi);

    // h-indeksi düşükken tek bir patent de bloğu açar.
    $patent = sartDugum(
        $depo->degerlendir($esik, [sartFaaliyet('Ulusal Patent', Kategori::Patent, null)], new Profil(hIndeksi: 2)),
        $ad,
    );
    expect($patent->durum)->toBe(Durum::Saglandi);

    // Yurt dışı araştırma deneyimi doçentlikte 3 ay, profesörlükte 6 ay.
    $profesor = $depo->bul('İnönü Üniversitesi', 'profesorluk', 'fen');
    expect(sartDugum($depo->degerlendir($esik, [], new Profil(yurtdisiAy: 3)), $ad)->durum)
        ->toBe(Durum::Saglandi)
        ->and(sartDugum($depo->degerlendir($profesor, [], new Profil(yurtdisiAy: 3)), $ad)->durum)
        ->toBe(Durum::Belirsiz);
});

test('İnönü makale puanını çeyrekliğe ve yayın türüne göre ayırıyor', function () {
    $katalog = sartDepo()->katalog('inonu-2026');
    $kodlar = array_keys($katalog->maddeler);

    $puan = function (string $kaynak, string $tur) use ($katalog, $kodlar): int {
        $f = sartFaaliyet($kaynak);
        $f->yayin_turu = $tur;

        return $katalog->puan($f, $kodlar);
    };

    // A.1 çeyreklik kademeleri.
    expect($puan('SCIE/SSCI (Q1)', 'ozgun_makale'))->toBe(200)
        ->and($puan('SCIE/SSCI (Q3)', 'ozgun_makale'))->toBe(90)
        ->and($puan('TR Dizin', 'ozgun_makale'))->toBe(40);

    // A.6: aynı dergilerde derleme, teknik not ve özet satır puanının 1/3'ü.
    expect($puan('SCIE/SSCI (Q1)', 'derleme'))->toBe(66)
        ->and($puan('SCIE/SSCI (Q1)', 'vaka_teknik_not'))->toBe(66)
        ->and($puan('TR Dizin', 'derleme'))->toBe(13);

    // Yazar çarpanı A-D bölümlerinde işler, projede işlemez (Madde 12).
    $cokYazarli = sartFaaliyet('SCIE/SSCI (Q1)', yazarRolu: 'yazar_3');
    $cokYazarli->yazarlar = 'A, B, C, D';
    expect($katalog->puan($cokYazarli, $kodlar))->toBe(130);          // 200 × 0,65

    $proje = sartFaaliyet('TÜBİTAK', Kategori::Proje, 'yurutucu');
    $proje->yazarlar = 'A, B, C, D';
    expect($katalog->puan($proje, $kodlar))->toBe(112);               // çarpansız
});

test('İTÜ puan cetveli birime göre değişiyor', function () {
    $depo = sartDepo();

    $puan = function (string $cetvel, string $kaynak, Kategori $kategori = Kategori::Makale) use ($depo): int {
        $katalog = $depo->katalog($cetvel);

        return $katalog->puan(sartFaaliyet($kaynak, $kategori), array_keys($katalog->maddeler));
    };

    // A bölümü üç sütunlu: AHCI genel birimlerde sayılmıyor, H/S/MF'de 4,
    // konservatuvarda 10 puan.
    expect($puan('itu-2022', 'AHCI'))->toBe(0)
        ->and($puan('itu-2022-hs', 'AHCI'))->toBe(4)
        ->and($puan('itu-2022-tmdk', 'AHCI'))->toBe(10);

    // TR Dizin konservatuvarda diğer birimlerin iki katından fazla.
    expect($puan('itu-2022', 'TR Dizin'))->toBe(3)
        ->and($puan('itu-2022-tmdk', 'TR Dizin'))->toBe(8);

    // Scopus çeyreklikleri bütün birimlerde aynı.
    foreach (['itu-2022', 'itu-2022-hs', 'itu-2022-mf', 'itu-2022-tmdk', 'itu-2022-moda'] as $cetvel) {
        expect($puan($cetvel, 'SCIE/SSCI (Q1)'))->toBe(10);
    }

    // Aynı sanatsal kayıt konservatuvarda müzik satırından, Moda Tasarımı'nda
    // moda satırından puanlanıyor; genel cetvelde hiç karşılığı yok.
    $sergi = 'Kişisel Etkinlik (Uluslararası)';
    expect($puan('itu-2022-tmdk', $sergi, Kategori::SanatselEtkinlik))->toBe(10)
        ->and($puan('itu-2022-moda', $sergi, Kategori::SanatselEtkinlik))->toBe(30)
        ->and($puan('itu-2022', $sergi, Kategori::SanatselEtkinlik))->toBe(0);
});

test('İTÜ eser puanı kapsamı birime göre daralıyor', function () {
    $depo = sartDepo();

    $kapsam = fn (string $cetvel): array => $depo->katalog($cetvel)->coz(['ESER-PUANI']);

    // Tüm Birimler'de eser puanına yalnızca Scopus Q1-Q3 makaleleri giriyor.
    expect($kapsam('itu-2022'))->toBe(['A.1', 'A.2', 'A.3']);

    // Hukuk ve Sosyoloji'de A, B ve C bölümlerinin tamamı sayılıyor.
    expect($kapsam('itu-2022-hs'))->toContain('B.1')
        ->and($kapsam('itu-2022-hs'))->toContain('C.7')
        ->and($kapsam('itu-2022'))->not->toContain('B.1');

    // Konservatuvarda müzik ve sahne çalışmaları da eser puanına giriyor.
    expect($kapsam('itu-2022-tmdk'))->toContain('L.5')
        ->and($kapsam('itu-2022-moda'))->toContain('M.1');
});

test('İTÜ Türkçe yayın koşulu sağlanmazsa eser puanı sınırı yükseliyor', function () {
    $depo = sartDepo();
    $esik = $depo->bul('İstanbul Teknik Üniversitesi', 'docentlik', 'muhendislik');
    $ad = 'Tablo 2 — Türkçe Yayın';
    $profil = new Profil(doktoraTarihi: Carbon::parse('2015-01-01'));

    $q1 = fn () => sartFaaliyet('SCIE/SSCI (Q1)', tarih: '2024-01-01');
    $tr = fn () => sartFaaliyet('TR Dizin', tarih: '2024-01-01');

    // Yedi Q1 makale = 70 puan: normal sınırı (70) geçiyor ama Türkçe yayın yok,
    // o yüzden yükseltilmiş sınır (73) aranıyor ve karşılanmıyor.
    $dugum = sartDugum($depo->degerlendir($esik, array_map($q1, range(1, 7)), $profil), $ad);
    expect($dugum->durum)->toBe(Durum::Saglanmadi)
        ->and($dugum->cocuklar[1]->gerekli)->toBe(73);

    // Tek bir TR Dizin makalesi koşulu doğrudan sağlıyor.
    $trIle = sartDugum($depo->degerlendir($esik, [...array_map($q1, range(1, 7)), $tr()], $profil), $ad);
    expect($trIle->durum)->toBe(Durum::Saglandi);

    // TR Dizin yoksa da sekiz Q1 makale (80 puan) yükseltilmiş sınırı geçiyor.
    $puanla = sartDugum($depo->degerlendir($esik, array_map($q1, range(1, 8)), $profil), $ad);
    expect($puanla->durum)->toBe(Durum::Saglandi);
});

test('İstanbul Üniversitesi üst çeyreklik makalesi varsa sayı bir azalıyor', function () {
    $depo = sartDepo();
    $esik = $depo->bul('İstanbul Üniversitesi', 'docentlik', 'saglik');
    $ad = 'Madde 9 — Makale';
    $profil = new Profil(doktoraTarihi: Carbon::parse('2015-01-01'));

    $q1 = fn () => sartFaaliyet('SCIE/SSCI (Q1)', tarih: '2024-01-01');
    $q4 = fn () => sartFaaliyet('SCIE/SSCI (Q4)', tarih: '2024-01-01');

    // Altı Q4 makale doğrudan yeter (yüksek sayı dalı).
    expect(sartDugum($depo->degerlendir($esik, array_map($q4, range(1, 6)), $profil), $ad)->durum)
        ->toBe(Durum::Saglandi);

    // Beş Q4 makale yetmez: ne altı adet var ne de üst çeyreklik makalesi.
    expect(sartDugum($depo->degerlendir($esik, array_map($q4, range(1, 5)), $profil), $ad)->durum)
        ->toBe(Durum::Saglanmadi);

    // Beş makalenin biri Q1 olunca düşük sayı dalı açılıyor.
    expect(sartDugum($depo->degerlendir($esik, [...array_map($q4, range(1, 4)), $q1()], $profil), $ad)->durum)
        ->toBe(Durum::Saglandi);
});

test('İstanbul Üniversitesi Matematik bölümü ayrı sayı kümesi kullanıyor', function () {
    $depo = sartDepo();

    $sayi = function (string $kadro, ?string $birim) use ($depo): int {
        $esik = $depo->bul('İstanbul Üniversitesi', $kadro, 'fen', $birim);
        $dugum = collect($esik['sart']['cocuklar'])->firstWhere('madde', 'Madde 10 — Makale');

        return $dugum['cocuklar'][0]['min_adet'];
    };

    // Genel fen alanında doçentlik 6 makale, Matematik'te 5.
    expect($sayi('docentlik', null))->toBe(6)
        ->and($sayi('docentlik', 'Matematik Bölümü'))->toBe(5)
        ->and($sayi('profesorluk', null))->toBe(8)
        ->and($sayi('profesorluk', 'Matematik Bölümü'))->toBe(7);
});

test('İstanbul Üniversitesi yazar katsayısı sorumlu yazarı ayırıyor', function () {
    $katalog = sartDepo()->katalog('istanbul-2026');
    $kodlar = array_keys($katalog->maddeler);

    $puan = function (?string $rol, int $yazarSayisi) use ($katalog, $kodlar): int {
        $f = sartFaaliyet('SCIE/SSCI (Q1)', yazarRolu: $rol);          // 2.a.1 → 60 puan
        $f->yazarlar = implode(', ', array_map(fn ($i) => "Yazar {$i}", range(1, $yazarSayisi)));

        return $katalog->puan($f, $kodlar);
    };

    // Sorumlu yazar üç yazarlıda 0,60; diğer yazarlar 0,25.
    expect($puan('baslica', 3))->toBe(36)
        ->and($puan('ortak', 3))->toBe(15);

    // Yönerge sıraya bakmıyor: birinci isim de "diğer yazarlar" satırında.
    expect($puan('ilk', 3))->toBe(15);

    // Yirmiden fazla yazarlı yayında sorumlu yazar dışındakiler 0,04 alır.
    expect($puan('ortak', 25))->toBe(2)
        ->and($puan('baslica', 25))->toBe(24);

    // Atıf ve bildiri puanı yazarlar arasında bölüşülmez (Tablo 1, 3 ve 4).
    $atif = sartFaaliyet('WoS / Scopus', Kategori::Atif, null);
    $atif->yazarlar = 'A, B, C, D, E';
    expect($katalog->puan($atif, $kodlar))->toBe(3);
});

test('Dokuz Eylül iki ayrı puan barajı istiyor: zorunlu küme ve genel toplam', function () {
    $depo = sartDepo();
    $esik = $depo->bul('Dokuz Eylül Üniversitesi', 'dr_ogr_uyesi', 'muhendislik');
    $profil = new Profil(yds: 70);

    // Zorunlu küme (ZORUNLU-FEN) girişimcilik kalemlerini sayar, atıf saymaz.
    $atif = fn () => sartFaaliyet('WoS / Scopus', Kategori::Atif, null, '2024-01-01');
    $makale = fn () => sartFaaliyet('SCIE/SSCI (Q1)', tarih: '2024-01-01');

    // On altı atıf = 80 puan: genel toplamı karşılar, zorunlu kümeyi karşılamaz.
    $sonuc = $depo->degerlendir($esik, array_map($atif, range(1, 16)), $profil);

    expect(sartDugum($sonuc, 'Alanınızın zorunlu puan kalemlerinden en az 50 puan')->mevcut)->toBe(0)
        ->and(sartDugum($sonuc, 'Tüm faaliyetlerden toplam en az 80 puan')->mevcut)->toBe(80);

    // Dört makale = 100 puan: ikisini birden karşılar.
    $makaleli = $depo->degerlendir($esik, array_map($makale, range(1, 4)), $profil);

    expect(sartDugum($makaleli, 'Alanınızın zorunlu puan kalemlerinden en az 50 puan')->durum)
        ->toBe(Durum::Saglandi)
        ->and(sartDugum($makaleli, 'Tüm faaliyetlerden toplam en az 80 puan')->durum)
        ->toBe(Durum::Saglandi);
});

test('Dokuz Eylül zorunlu puan kümesi alana göre değişiyor', function () {
    $depo = sartDepo();
    $katalog = $depo->katalog('dokuz-eylul-2024');

    $fen = $katalog->coz(['ZORUNLU-FEN']);
    $sosyal = $katalog->coz(['ZORUNLU-SOSYAL']);
    $mimarlik = $katalog->coz(['ZORUNLU-MIMARLIK']);

    // Fen kümesi derleme makalelerden yalnızca 2.a'yı sayar; sosyal hepsini.
    expect($fen)->toContain('2.a')
        ->and($fen)->not->toContain('2.c')
        ->and($sosyal)->toContain('2.c');

    // Kitaplar sosyal ve mimarlıkta zorunlu, fende değil.
    expect($sosyal)->toContain('5.a')
        ->and($fen)->not->toContain('5.a');

    // Mimarlık ayrıca yarışma ve uygulama projelerini (8.f) sayıyor; Madde
    // 1.10.1/c ile kadro puan çizelgeleri mimarlık için 8.a, 8.b ve 8.f diyor,
    // 8.c'yi (üniversite-sanayi projesi) hiçbir kümeye koymuyor.
    expect($mimarlik)->toContain('8.f')
        ->and($mimarlik)->not->toContain('8.c')
        ->and($sosyal)->not->toContain('8.f');

    // Güzel sanatların kuramsal alanı tiyatroyu (33), uygulamalı alanı D
    // bölümünün 24-34 arasının tamamını, konservatuvar ise 38-41'i sayıyor.
    $gsKuramsal = $katalog->coz(['ZORUNLU-GS-KURAMSAL']);
    $gsUygulamali = $katalog->coz(['ZORUNLU-GS-UYGULAMALI']);
    $konservatuvar = $katalog->coz(['ZORUNLU-KONSERVATUVAR']);

    expect($gsKuramsal)->toContain('33.b.2')
        ->and($gsKuramsal)->not->toContain('24.a.1')
        ->and($gsUygulamali)->toContain('24.a.1')
        ->and($gsUygulamali)->toContain('26.f')
        ->and($gsUygulamali)->not->toContain('38.b.1')
        ->and($konservatuvar)->toContain('41.c')
        ->and($konservatuvar)->not->toContain('24.a.1');
});

test('Dokuz Eylül güzel sanatlar ve konservatuvar eşikleri programa bağlı', function () {
    $depo = sartDepo();

    // Aynı temel alanda on iki program var; program seçilmeden ayrım kurulamaz.
    expect($depo->bul('Dokuz Eylül Üniversitesi', 'dr_ogr_uyesi', 'guzel_sanatlar'))->toBeNull();

    $muzikoloji = $depo->bul(
        'Dokuz Eylül Üniversitesi', 'dr_ogr_uyesi', 'guzel_sanatlar',
        'Güzel Sanatlar — Müzikoloji',
    );
    $dans = $depo->bul(
        'Dokuz Eylül Üniversitesi', 'docentlik', 'guzel_sanatlar',
        'Konservatuvar — Dans ve Koreografi',
    );

    expect($muzikoloji['anahtar'])->toBe('deu-gs-muzikoloji-dr-guzel_sanatlar')
        ->and($dans['anahtar'])->toBe('deu-kons-dans-docent-guzel_sanatlar');

    // Kuramsal ve uygulamalı alanlar farklı zorunlu puan kümesine bağlı.
    $kume = fn (array $esik): string => json_encode($esik['sart'], JSON_UNESCAPED_UNICODE);

    expect($kume($muzikoloji))->toContain('ZORUNLU-GS-KURAMSAL')
        ->and($kume($dans))->toContain('ZORUNLU-KONSERVATUVAR');
});

test('Dokuz Eylül profesörlük doçentlik koşullarını doçentlik sonrası tekrarlatıyor', function () {
    $depo = sartDepo();
    $profil = new Profil(
        doktoraTarihi: Carbon::parse('2010-01-01'),
        docentlikTarihi: Carbon::parse('2020-01-01'),
        yds: 70,
    );

    $esik = $depo->bul('Dokuz Eylül Üniversitesi', 'profesorluk', 'muhendislik');
    $ad = 'Doçentlik sonrası, SCI, SCI-Expanded veya SSCI dergilerinde en az 5 araştırma makalesi';

    // Doçentlik ÖNCESİ beş makale koşulu karşılamıyor.
    $onceki = fn () => sartFaaliyet('SCIE/SSCI (Q1)', tarih: '2015-01-01');
    expect(sartDugum($depo->degerlendir($esik, array_map($onceki, range(1, 5)), $profil), $ad)->mevcut)
        ->toBe(0);

    // Doçentlik sonrası beş makale karşılıyor.
    $sonraki = fn () => sartFaaliyet('SCIE/SSCI (Q1)', tarih: '2023-01-01');
    expect(sartDugum($depo->degerlendir($esik, array_map($sonraki, range(1, 5)), $profil), $ad)->durum)
        ->toBe(Durum::Saglandi);

    // Profesörlük ağacı doçentliğin PUAN barajlarını taşımamalı: yönerge
    // yalnızca yayın koşullarını tekrarlatıyor, profesörlüğün kendi barajı ayrı.
    $barajlar = collect($esik['sart']['cocuklar'])
        ->pluck('min_puan')->filter()->values()->all();

    expect($barajlar)->toBe([200, 70, 400]);
});

test('Dokuz Eylül bir makaleyi girişimcilik puanıyla değiştirmeye izin veriyor', function () {
    $depo = sartDepo();
    $esik = $depo->bul('Dokuz Eylül Üniversitesi', 'docentlik', 'sosyal');
    $ad = 'Doktora sonrası, hakemli dergilerde en az 5 araştırma makalesi';
    $profil = new Profil(doktoraTarihi: Carbon::parse('2015-01-01'));

    $makale = fn () => sartFaaliyet('SCIE/SSCI (Q1)', tarih: '2024-01-01');
    $patent = fn () => sartFaaliyet('Ulusal Patent', Kategori::Patent, null, '2024-01-01');

    // Dört makale tek başına yetmiyor.
    expect(sartDugum($depo->degerlendir($esik, array_map($makale, range(1, 4)), $profil), $ad)->durum)
        ->toBe(Durum::Saglanmadi);

    // Dört makale + ulusal patent (30 puan) telafiyi açıyor.
    $telafili = sartDugum(
        $depo->degerlendir($esik, [...array_map($makale, range(1, 4)), $patent()], $profil), $ad,
    );

    expect($telafili->durum)->toBe(Durum::Saglandi)
        ->and($telafili->telafiIleSaglandi())->toBeTrue();

    // Telafi BİLEŞİK: yalnızca girişimcilik puanı yetmez, dört makale de şart.
    // Üç makale + patent hâlâ düşüyor — yönerge yalnızca BİR makalenin yerine
    // geçmesine izin veriyor.
    expect(sartDugum($depo->degerlendir($esik, [...array_map($makale, range(1, 3)), $patent()], $profil), $ad)->durum)
        ->toBe(Durum::Saglanmadi);
});

test('ÜAK cetveli çok yazarlı yayında puanı yazarlara eşit bölüyor', function () {
    // ÜAK Tablo 1'in genel kuralı: "Tek yazarlı yayınlarda yazar tam puan alır.
    // Çok yazarlı yayınlarda puan yazarlar arasında eşit olarak bölünür."
    // Bölme uygulanmazsa ÜAK'a devreden bütün üniversitelerde çok yazarlı
    // adayın puanı olduğundan YÜKSEK görünür.
    $katalog = sartDepo()->katalog('uak-2024-mart-fen');
    $kodlar = array_keys($katalog->maddeler);

    $puan = function (string $rol, int $yazarSayisi, string $kaynak = 'SCIE/SSCI (Q1)', Kategori $kategori = Kategori::Makale) use ($katalog, $kodlar): int {
        $f = sartFaaliyet($kaynak, $kategori, $rol);
        $f->yazarlar = implode(', ', array_map(fn ($i) => "Yazar {$i}", range(1, $yazarSayisi)));

        return $katalog->puan($f, $kodlar);
    };

    // Q1 makale 30 puan; iki yazarlıda 15, üçte 10, dörtte 7 (aşağı yuvarlanır).
    expect($puan('tek', 1))->toBe(30)
        ->and($puan('ortak', 2))->toBe(15)
        ->and($puan('ortak', 3))->toBe(10)
        ->and($puan('ortak', 4))->toBe(7);

    // ÜAK başlıca yazara ayrıcalık TANIMIYOR: kural yalnızca yazar sayısına
    // bakıyor, bütün roller aynı bölmeyi alır.
    expect($puan('baslica', 3))->toBe(10)
        ->and($puan('ilk', 3))->toBe(10);

    // "Patentlerde puan kişi sayısına bölünür" — patent de bölünür.
    expect($puan('ortak', 2, 'Ulusal Patent', Kategori::Patent))->toBe(5);

    // Atıf bölünmez: ÜAK atıfta bölme kuralı yazmıyor.
    expect($puan('ortak', 4, 'WoS / Scopus', Kategori::Atif))
        ->toBe($puan('tek', 1, 'WoS / Scopus', Kategori::Atif));
});

test('dönemli toplam barajı adaya dönemi de söylüyor', function () {
    // Bir yönerge aynı kadroda iki toplam barajı isteyebiliyor: biri kariyerin
    // tamamından, biri yalnızca doçentlik sonrasından. Dönem metne yazılmazsa
    // aday iki satırda da aynı cümleyi görür ve farkı anlayamaz.
    $donemsiz = Kalip::toplam(250);
    $docentlik = Kalip::toplam(100, Kalip::DOCENTLIK_SONRASI);
    $pencere = Kalip::toplam(80, Kalip::sonYil(3));
    $ikisi = Kalip::toplam(60, Kalip::sonYil(5, 'doktora'));

    expect($donemsiz['aciklama'])->toBe('Tüm faaliyetlerden toplam en az 250 puan')
        ->and($docentlik['aciklama'])->toBe('Tüm faaliyetlerden toplam en az 100 puan (doçentlik unvanınızdan sonra)')
        ->and($pencere['aciklama'])->toBe('Tüm faaliyetlerden toplam en az 80 puan (son 3 yılda)')
        ->and($ikisi['aciklama'])->toBe('Tüm faaliyetlerden toplam en az 60 puan (doktora unvanınızdan sonra, son 5 yılda)');

    // Korpusta gerçekten iki toplamı olan bir eşikte ayrım görünüyor mu?
    $esik = sartDepo()->bul('İstinye Üniversitesi', 'profesorluk', 'fen');
    $toplamlar = collect($esik['sart']['cocuklar'])
        ->where('rol', 'toplam')->pluck('aciklama')->all();

    expect($toplamlar)->toHaveCount(2)
        ->and($toplamlar[0])->not->toBe($toplamlar[1]);
});

test('İstinye puanlamayı ÜAK cetveline devrediyor', function () {
    $depo = sartDepo();

    // On iki temel alanın hepsinde tanımlı ve hepsi ÜAK cetvelini kullanıyor.
    foreach (TemelAlan::cases() as $alan) {
        $esik = $depo->bul('İstinye Üniversitesi', 'docentlik', $alan->value);

        expect($esik)->not->toBeNull($alan->value)
            ->and($esik['cetvel'])->toBe("uak-2024-mart-{$alan->value}");
    }

    // Dr. Öğr. Üyeliğinde baraj doktora sonrasına bağlı: doktoradan önceki
    // çalışmalar sayılmaz.
    $profil = new Profil(doktoraTarihi: Carbon::parse('2020-01-01'));
    $dr = $depo->bul('İstinye Üniversitesi', 'dr_ogr_uyesi', 'fen');
    $makale = fn (string $tarih) => sartFaaliyet('SCIE/SSCI (Q1)', tarih: $tarih);

    expect($depo->degerlendir($dr, [$makale('2018-01-01')], $profil)->kosullar()[0]->mevcut)->toBe(0)
        ->and($depo->degerlendir($dr, [$makale('2023-01-01')], $profil)->kosullar()[0]->mevcut)->toBe(30);
});

test('Toros alan gruplarını kadroya göre farklı topluyor', function () {
    $depo = sartDepo();

    $baraj = function (string $kadro, string $alan) use ($depo): int {
        $esik = $depo->bul('Toros Üniversitesi', $kadro, $alan);
        $sart = $esik['sart'];

        return collect($sart['cocuklar'] ?? [$sart])->firstWhere('rol', 'toplam')['min_puan'];
    };

    // Dr. ve profesörlükte sosyal ayrı satırda, doçentlikte mühendislik ve
    // sağlıkla aynı grupta — yönergenin kendi gruplaması kadroya göre değişiyor.
    expect($baraj('dr_ogr_uyesi', 'muhendislik'))->toBe(30)
        ->and($baraj('dr_ogr_uyesi', 'sosyal'))->toBe(25)
        ->and($baraj('docentlik', 'muhendislik'))->toBe(120)
        ->and($baraj('docentlik', 'sosyal'))->toBe(120)
        ->and($baraj('profesorluk', 'muhendislik'))->toBe(180)
        ->and($baraj('profesorluk', 'sosyal'))->toBe(150);

    // Güzel Sanatlar ve Mimarlık doçentlikte ayrı ve daha düşük.
    expect($baraj('docentlik', 'mimarlik'))->toBe(100)
        ->and($baraj('profesorluk', 'guzel_sanatlar'))->toBe(150);

    // Yönergenin anmadığı alanlar kapsam dışı.
    expect($depo->bul('Toros Üniversitesi', 'docentlik', 'fen'))->toBeNull()
        ->and($depo->bul('Toros Üniversitesi', 'docentlik', 'hukuk'))->toBeNull();
});

test('Toros güzel sanatlarda makale yerine yarışma derecesi kabul ediyor', function () {
    $depo = sartDepo();
    $esik = $depo->bul('Toros Üniversitesi', 'dr_ogr_uyesi', 'mimarlik');
    $ad = 'Madde 4/a-3';

    // Hiçbir yayın yok: dal beyan içerdiği için kesin ret değil, belirsiz.
    expect(sartDugum($depo->degerlendir($esik, [], new Profil), $ad)->durum)
        ->toBe(Durum::Belirsiz);

    // Yarışma derecesi makale olmadan da koşulu açıyor.
    $yarisma = sartFaaliyet('Yarışma Derecesi / Mansiyon', Kategori::Odul, null, '2024-01-01');
    expect(sartDugum($depo->degerlendir($esik, [$yarisma], new Profil), $ad)->durum)
        ->toBe(Durum::Saglandi);

    // Makale de tek başına yeterli.
    $makale = sartFaaliyet('SCIE/SSCI (Q1)', tarih: '2024-01-01');
    expect(sartDugum($depo->degerlendir($esik, [$makale], new Profil), $ad)->durum)
        ->toBe(Durum::Saglandi);
});

test('Alanya birinci yazara yazar sayısından bağımsız tam puan veriyor', function () {
    // Yönergenin notu: "Birinci yazar tam puan alır; birden çok yazarlı
    // çalışmalarda birinci yazar tam puan alır ve tam puan diğer yazarlar
    // arasında eşit olarak pay edilir." Korpustaki öteki yönergelerin hepsi
    // TEK bir tam puanı bölüyor; burada birinci yazarınki hiç bölünmüyor.
    $katalog = sartDepo()->katalog('alanya-2024');
    $kodlar = array_keys($katalog->maddeler);

    $puan = function (string $rol, int $yazarSayisi) use ($katalog, $kodlar): int {
        $f = sartFaaliyet('SCIE/SSCI (Q1)', yazarRolu: $rol);          // A.1 → 20 puan
        $f->yazarlar = implode(', ', array_map(fn ($i) => "Yazar {$i}", range(1, $yazarSayisi)));

        return $katalog->puan($f, $kodlar);
    };

    // Birinci yazar her zaman tam puan.
    expect($puan('ilk', 1))->toBe(20)
        ->and($puan('ilk', 3))->toBe(20)
        ->and($puan('ilk', 8))->toBe(20);

    // Diğer yazarlar ikinci bir tam puanı bölüşür: 1/(n−1).
    expect($puan('yazar_2', 2))->toBe(20)
        ->and($puan('yazar_2', 3))->toBe(10)
        ->and($puan('yazar_3', 5))->toBe(5);

    // Yönerge sorumlu yazara ayrıcalık tanımıyor; sırasını belirtmeyen de
    // birinci yazar payını alamaz.
    expect($puan('baslica', 3))->toBe(10)
        ->and($puan('ortak', 3))->toBe(10);
});

test('Alanya alan ayrımı yapmadan on iki temel alana da tanımlı', function () {
    $depo = sartDepo();

    foreach (TemelAlan::cases() as $alan) {
        foreach (['dr_ogr_uyesi', 'docentlik', 'profesorluk'] as $kadro) {
            expect($depo->bul('Alanya Üniversitesi', $kadro, $alan->value))
                ->not->toBeNull("{$kadro} · {$alan->value}");
        }
    }

    // Korpusun en dar doçent-profesör aralığı: 50 → 60.
    $baraj = function (string $kadro) use ($depo): int {
        $sart = $depo->bul('Alanya Üniversitesi', $kadro, 'fen')['sart'];

        return collect($sart['cocuklar'] ?? [$sart])->firstWhere('rol', 'toplam')['min_puan'];
    };

    expect($baraj('dr_ogr_uyesi'))->toBe(20)
        ->and($baraj('docentlik'))->toBe(50)
        ->and($baraj('profesorluk'))->toBe(60);
});

test('İbn Haldun sanatsal kalemleri yalnızca iki fakültede sayıyor', function () {
    $depo = sartDepo();

    $puan = function (string $cetvel, string $kaynak, Kategori $kategori) use ($depo): int {
        $katalog = $depo->katalog($cetvel);

        return $katalog->puan(sartFaaliyet($kaynak, $kategori, null), array_keys($katalog->maddeler));
    };

    // Yayın puanları iki sütunda birebir aynı.
    expect($puan('ibn-haldun-2024', 'SCIE/SSCI (Q1)', Kategori::Makale))->toBe(35)
        ->and($puan('ibn-haldun-2024-sanat', 'SCIE/SSCI (Q1)', Kategori::Makale))->toBe(35);

    // Sanatsal kalemler yalnızca MTGF/İF sütununda puanlı; ötekinde tabloda
    // "GD (Geçerli Değil)" yazıyor.
    $sergi = 'Kişisel Etkinlik (Uluslararası)';
    expect($puan('ibn-haldun-2024', $sergi, Kategori::SanatselEtkinlik))->toBe(0)
        ->and($puan('ibn-haldun-2024-sanat', $sergi, Kategori::SanatselEtkinlik))->toBe(10);

    // İletişim Fakültesi sosyal alanı İTBF ile paylaşıyor; birim seçilmezse
    // sanatsal kalemlerin sayılmadığı grup 1 eşiği gelir (güvenli taraf).
    expect($depo->bul('İbn Haldun Üniversitesi', 'docentlik', 'sosyal')['cetvel'])
        ->toBe('ibn-haldun-2024')
        ->and($depo->bul('İbn Haldun Üniversitesi', 'docentlik', 'sosyal', 'İletişim Fakültesi')['cetvel'])
        ->toBe('ibn-haldun-2024-sanat');
});

test('İbn Haldun hukuk grubunda baraj yüksek ama küme geniş', function () {
    $depo = sartDepo();
    $profil = new Profil(dersYariyil: 4);

    $genel = $depo->bul('İbn Haldun Üniversitesi', 'dr_ogr_uyesi', 'sosyal');
    $hukuk = $depo->bul('İbn Haldun Üniversitesi', 'dr_ogr_uyesi', 'hukuk');

    // TR Dizin makalesi (10 puan) ulusal kalem: hukuk kümesine giriyor,
    // genel kümeye girmiyor.
    $ulusal = fn () => sartFaaliyet('TR Dizin', tarih: '2024-01-01');

    $genelPuan = sartDugum($depo->degerlendir($genel, array_map($ulusal, range(1, 5)), $profil), 'B bölümü');
    $hukukPuan = sartDugum($depo->degerlendir($hukuk, array_map($ulusal, range(1, 5)), $profil), 'B bölümü');

    expect($genelPuan->mevcut)->toBe(0)
        ->and($genelPuan->gerekli)->toBe(30)
        ->and($hukukPuan->mevcut)->toBe(50)
        ->and($hukukPuan->gerekli)->toBe(40)
        ->and($hukukPuan->durum)->toBe(Durum::Saglandi);
});

test('İzmir Demokrasi tez ve proje koşullarını TR Dizin yayınıyla telafi ediyor', function () {
    $depo = sartDepo();
    $esik = $depo->bul('İzmir Demokrasi Üniversitesi', 'profesorluk', 'fen');
    $profil = new Profil(yds: 70, programDili: 'turkce');

    $trDizin = fn () => sartFaaliyet('TR Dizin', yazarRolu: 'ilk', tarih: '2024-01-01');
    $proje = fn () => sartFaaliyet('TÜBİTAK', Kategori::Proje, 'yurutucu', '2024-01-01');

    $tezAd = 'Madde 1/1-c';
    $projeAd = 'Madde 1/1-ç';

    // Hiçbiri yoksa iki koşul da düşer.
    $bos = $depo->degerlendir($esik, [], $profil);
    expect(sartDugum($bos, $tezAd)->durum)->toBe(Durum::Saglanmadi)
        ->and(sartDugum($bos, $projeAd)->durum)->toBe(Durum::Saglanmadi);

    // Profesörlükte telafi 2 yayın istiyor; tek yayın yetmez.
    $tek = $depo->degerlendir($esik, [$trDizin()], $profil);
    expect(sartDugum($tek, $tezAd)->durum)->toBe(Durum::Saglanmadi);

    // İki yayın telafiyi açıyor.
    $iki = $depo->degerlendir($esik, [$trDizin(), $trDizin()], $profil);
    expect(sartDugum($iki, $tezAd)->durum)->toBe(Durum::Saglandi)
        ->and(sartDugum($iki, $tezAd)->telafiIleSaglandi())->toBeTrue();

    // İki gerçek proje telafiye gerek bırakmıyor.
    $projeli = $depo->degerlendir($esik, [$proje(), $proje()], $profil);
    expect(sartDugum($projeli, $projeAd)->durum)->toBe(Durum::Saglandi)
        ->and(sartDugum($projeli, $projeAd)->telafiIleSaglandi())->toBeFalse();

    // Doçentlikte aynı telafi tek yayınla açılıyor (sayı 1).
    $docent = $depo->bul('İzmir Demokrasi Üniversitesi', 'docentlik', 'fen');
    expect(sartDugum($depo->degerlendir($docent, [$trDizin()], $profil), 'Madde 2/1-c')->durum)
        ->toBe(Durum::Saglandi);
});

test('İzmir Demokrasi ikinci yazarlı yayınları saymıyor', function () {
    // Yönerge "birinci veya ikinci yazar" diyor ama motorun yazar süzgecinde
    // öyle bir kademe yok; `ilk` ile girildi ve koşul olduğundan zor görünür.
    $depo = sartDepo();
    $esik = $depo->bul('İzmir Demokrasi Üniversitesi', 'dr_ogr_uyesi', 'fen');
    $profil = new Profil(yds: 70, programDili: 'turkce');
    $ad = 'Madde 3/1-b';

    $ikinci = fn () => sartFaaliyet('SCIE/SSCI (Q1)', yazarRolu: 'yazar_2', tarih: '2024-01-01');
    $birinci = fn () => sartFaaliyet('SCIE/SSCI (Q1)', yazarRolu: 'ilk', tarih: '2024-01-01');

    expect(sartDugum($depo->degerlendir($esik, [$ikinci()], $profil), $ad)->durum)
        ->toBe(Durum::Saglanmadi)
        ->and(sartDugum($depo->degerlendir($esik, [$birinci()], $profil), $ad)->durum)
        ->toBe(Durum::Saglandi);
});

test('Işık 1,3 katsayısını yalnızca bazı birimlere uyguluyor', function () {
    $depo = sartDepo();

    $puan = function (string $cetvel, string $kaynak, Kategori $kategori = Kategori::Makale, ?string $rol = 'tek') use ($depo): int {
        $katalog = $depo->katalog($cetvel);

        return $katalog->puan(sartFaaliyet($kaynak, $kategori, $rol), array_keys($katalog->maddeler));
    };

    // A.1 (uluslararası yayın) ve B (proje) çarpanlı; çarpımdan sonra aşağı
    // yuvarlanıyor: 15 × 1,3 = 19,5 → 19.
    expect($puan('isik-2019', 'SCIE/SSCI (Q1)'))->toBe(15)
        ->and($puan('isik-2019-carpanli', 'SCIE/SSCI (Q1)'))->toBe(19);

    // Proje de A.1 ile aynı kuralda: 12 × 1,3 = 15,6 → 15.
    expect($puan('isik-2019', 'TÜBİTAK', Kategori::Proje, 'yurutucu'))->toBe(12)
        ->and($puan('isik-2019-carpanli', 'TÜBİTAK', Kategori::Proje, 'yurutucu'))->toBe(15);

    // A.2 (ulusal yayın) çarpanın DIŞINDA: iki cetvelde de aynı.
    expect($puan('isik-2019', 'TR Dizin'))->toBe(6)
        ->and($puan('isik-2019-carpanli', 'TR Dizin'))->toBe(6);

    // Mühendislik ve Fizik çarpansız cetveli, Matematik çarpanlıyı kullanıyor;
    // ikisi de `fen`/`muhendislik` alanında, ayrım birimle yapılıyor.
    expect($depo->bul('Işık Üniversitesi', 'docentlik', 'muhendislik')['cetvel'])->toBe('isik-2019')
        ->and($depo->bul('Işık Üniversitesi', 'docentlik', 'fen')['cetvel'])->toBe('isik-2019')
        ->and($depo->bul('Işık Üniversitesi', 'docentlik', 'fen', 'Matematik Bölümü')['cetvel'])
        ->toBe('isik-2019-carpanli');
});

test('Işık yazar payını sıraya bağlıyor, sayıya değil', function () {
    // Açıklama 2: birinci isim ve sorumlu yazar %100, ikinci %90, üçüncü %80,
    // dördüncü %70, beşinci ve sonrası %50. Yazar SAYISI hiç rol oynamıyor.
    $katalog = sartDepo()->katalog('isik-2019');
    $kodlar = array_keys($katalog->maddeler);

    $puan = function (string $rol, int $yazarSayisi) use ($katalog, $kodlar): int {
        $f = sartFaaliyet('SCIE/SSCI (Q1)', yazarRolu: $rol);          // A.1.1.a → 15 puan
        $f->yazarlar = implode(', ', array_map(fn ($i) => "Yazar {$i}", range(1, $yazarSayisi)));

        return $katalog->puan($f, $kodlar);
    };

    // Aynı rol, farklı yazar sayısı → aynı puan.
    expect($puan('yazar_3', 3))->toBe($puan('yazar_3', 9))
        ->and($puan('ilk', 2))->toBe($puan('ilk', 12));

    // Sıra kademeleri: %100 / %90 / %80 / %70 / %50.
    expect($puan('ilk', 6))->toBe(15)
        ->and($puan('baslica', 6))->toBe(15)
        ->and($puan('yazar_2', 6))->toBe(13)
        ->and($puan('yazar_3', 6))->toBe(12)
        ->and($puan('yazar_4', 6))->toBe(10)
        ->and($puan('yazar_5', 6))->toBe(7)
        ->and($puan('ortak', 6))->toBe(7);
});

test('Işık mühendislikte makale sayısı yerine puan barajı kullanıyor', function () {
    $depo = sartDepo();
    $profil = new Profil(docentlikTarihi: Carbon::parse('2020-01-01'));
    $q1 = fn (string $tarih = '2023-01-01') => sartFaaliyet('SCIE/SSCI (Q1)', tarih: $tarih);

    // Sosyal doçentlikte SAYI koşulu var (en az 1 A.1.1 makale).
    $sosyal = $depo->bul('Işık Üniversitesi', 'docentlik', 'sosyal');
    expect(sartDugum($depo->degerlendir($sosyal, [$q1()], $profil), 'Madde 7(2)-a')->gerekli)
        ->toBe(1);

    // Mühendislik doçentliğinde sayı yok, 45 puanlık alt baraj var.
    $muh = $depo->bul('Işık Üniversitesi', 'docentlik', 'muhendislik');
    $uc = $depo->degerlendir($muh, [$q1(), $q1(), $q1()], $profil);
    $dort = $depo->degerlendir($muh, [$q1(), $q1(), $q1(), $q1()], $profil);

    // Üç makale 45 puan (3 × 15), tam barajda; dördü rahat geçiyor.
    expect(sartDugum($uc, 'Madde 7(2)-c')->mevcut)->toBe(45)
        ->and(sartDugum($uc, 'Madde 7(2)-c')->durum)->toBe(Durum::Saglandi)
        ->and(sartDugum($dort, 'Madde 7(2)-c')->mevcut)->toBe(60);
});

test('İstanbul Kültür alt kapısı alana göre biçim değiştiriyor', function () {
    $depo = sartDepo();
    $profil = new Profil(doktoraTarihi: Carbon::parse('2015-01-01'), dersYariyil: 4);
    $q1 = fn () => sartFaaliyet('SCIE/SSCI (Q1)', tarih: '2024-01-01');

    // Sosyal ve Güzel Sanatlarda alt kapı yalnızca PUAN: tek Q1 makale (30 p)
    // 10 puanlık kapıyı geçiyor, makale sayısı hiç aranmıyor.
    $sosyal = $depo->degerlendir($depo->bul('İstanbul Kültür Üniversitesi', 'docentlik', 'sosyal'), [$q1()], $profil);
    expect(sartDugum($sosyal, 'TABLO 8')->durum)->toBe(Durum::Saglandi);

    // Mühendislikte hem sayı hem puan var. Tek Q1 makale (30 puan) ikisini de
    // düşürüyor: sayı 1/3, puan 30/40.
    $esikMuh = $depo->bul('İstanbul Kültür Üniversitesi', 'docentlik', 'muhendislik');
    $muhKosullar = collect($depo->degerlendir($esikMuh, [$q1()], $profil)->kosullar())
        ->filter(fn (SartSonucu $k) => str_contains($k->madde ?? '', 'TABLO 6'))->values();

    expect($muhKosullar)->toHaveCount(2)
        ->and($muhKosullar[0]->mevcut)->toBe(1)
        ->and($muhKosullar[0]->gerekli)->toBe(3)
        ->and($muhKosullar[1]->mevcut)->toBe(30)
        ->and($muhKosullar[1]->gerekli)->toBe(40);

    // İki Q1 makale (60 puan) puan kapısını açıyor ama sayı hâlâ eksik —
    // yönerge ikisini birden istiyor.
    $ikiMakale = collect($depo->degerlendir($esikMuh, [$q1(), $q1()], $profil)->kosullar())
        ->filter(fn (SartSonucu $k) => str_contains($k->madde ?? '', 'TABLO 6'))->values();

    expect($ikiMakale[0]->durum)->toBe(Durum::Saglanmadi)
        ->and($ikiMakale[1]->durum)->toBe(Durum::Saglandi);

    // Fen'de Matematik ayrı birim ve daha düşük eşik.
    $sayi = function (?string $birim) use ($depo): int {
        $esik = $depo->bul('İstanbul Kültür Üniversitesi', 'docentlik', 'fen', $birim);

        return collect($esik['sart']['cocuklar'])->firstWhere('min_puan')['min_puan'];
    };

    expect($sayi(null))->toBe(40)
        ->and($sayi('Matematik ve İstatistik'))->toBe(20);
});

test('İstanbul Kültür hukuk ve dil kapısını uluslararası yayınla telafi ediyor', function () {
    $depo = sartDepo();
    $esik = $depo->bul('İstanbul Kültür Üniversitesi', 'dr_ogr_uyesi', 'hukuk');
    $ad = 'TABLO 4';

    $tr = fn () => sartFaaliyet('TR Dizin', tarih: '2024-01-01');
    $q1 = fn () => sartFaaliyet('SCIE/SSCI (Q1)', tarih: '2024-01-01');

    // Üç TR Dizin yayını koşulu doğrudan sağlıyor.
    expect(sartDugum($depo->degerlendir($esik, [$tr(), $tr(), $tr()], new Profil), $ad)->durum)
        ->toBe(Durum::Saglandi);

    // İki TR Dizin yetmiyor; ama tek bir uluslararası yayın telafiyi açıyor.
    expect(sartDugum($depo->degerlendir($esik, [$tr(), $tr()], new Profil), $ad)->durum)
        ->toBe(Durum::Saglanmadi);

    $telafili = sartDugum($depo->degerlendir($esik, [$q1()], new Profil), $ad);
    expect($telafili->durum)->toBe(Durum::Saglandi)
        ->and($telafili->telafiIleSaglandi())->toBeTrue();
});

test('İstanbul Kültür kitap puanı hukuk ve dilde dört kat', function () {
    $depo = sartDepo();

    $puan = function (string $cetvel, string $kaynak) use ($depo): int {
        $katalog = $depo->katalog($cetvel);

        return $katalog->puan(sartFaaliyet($kaynak, Kategori::Kitap, null), array_keys($katalog->maddeler));
    };

    expect($puan('istanbul-kultur-2024', 'Uluslararası/Ulusal Kitap'))->toBe(5)
        ->and($puan('istanbul-kultur-2024-hukuk', 'Uluslararası/Ulusal Kitap'))->toBe(20)
        ->and($puan('istanbul-kultur-2024-dil', 'Uluslararası/Ulusal Kitap'))->toBe(20);

    // Kitap bölümü Hukuk'ta 10, Dil'de 5, diğerlerinde 3.
    expect($puan('istanbul-kultur-2024', 'Kitap Bölümü'))->toBe(3)
        ->and($puan('istanbul-kultur-2024-hukuk', 'Kitap Bölümü'))->toBe(10)
        ->and($puan('istanbul-kultur-2024-dil', 'Kitap Bölümü'))->toBe(5);

    // Sanatsal kalemler yalnızca Güzel Sanatlar varyantında.
    expect($puan('istanbul-kultur-2024', 'Kişisel Etkinlik (Uluslararası)'))->toBe(0);
});

test('Yalova altı alanı ayrı tabloyla ve ayrı bölüm tavanıyla puanlıyor', function () {
    $depo = sartDepo();

    $puan = function (string $cetvel, string $kaynak, Kategori $kategori = Kategori::Makale) use ($depo): int {
        $katalog = $depo->katalog($cetvel);

        return $katalog->puan(sartFaaliyet($kaynak, $kategori, null), array_keys($katalog->maddeler));
    };

    // Diğer ulusal hakemli makale: Sosyal 5, Mühendislik ve Sağlık 4,
    // Mimarlık ve Güzel Sanatlar 6.
    expect($puan('yalova-2024-sosyal', 'Diğer Ulusal Hakemli'))->toBe(5)
        ->and($puan('yalova-2024-muhendislik', 'Diğer Ulusal Hakemli'))->toBe(4)
        ->and($puan('yalova-2024-saglik', 'Diğer Ulusal Hakemli'))->toBe(4)
        ->and($puan('yalova-2024-mimarlik', 'Diğer Ulusal Hakemli'))->toBe(6)
        ->and($puan('yalova-2024-guzel-sanatlar', 'Diğer Ulusal Hakemli'))->toBe(6)
        ->and($puan('yalova-2024-spor', 'Diğer Ulusal Hakemli'))->toBe(5);

    // Sağlık tablosu derlemeyi özgün makaleden ayırıp düşük puanlıyor;
    // diğer tablolarda derleme tam makale puanı alıyor.
    $derleme = function (string $cetvel) use ($depo): int {
        $katalog = $depo->katalog($cetvel);
        $f = sartFaaliyet('SCIE/SSCI (Q1)', yazarRolu: null);
        $f->yayin_turu = 'derleme';

        return $katalog->puan($f, array_keys($katalog->maddeler));
    };

    expect($derleme('yalova-2024-sosyal'))->toBe(20)
        ->and($derleme('yalova-2024-saglik'))->toBe(5);

    // Sanatsal kalemler yalnızca Güzel Sanatlar varyantında puanlanıyor.
    expect($puan('yalova-2024-guzel-sanatlar', 'Kişisel Etkinlik (Uluslararası)', Kategori::SanatselEtkinlik))->toBe(25)
        ->and($puan('yalova-2024-sosyal', 'Kişisel Etkinlik (Uluslararası)', Kategori::SanatselEtkinlik))->toBe(0);

    // Bölüm tavanları: Sosyal'de 7. madde 20 puanla sınırlı, üç AB projesi
    // (3 × 15 = 45) tavanda kesiliyor.
    $katalog = $depo->katalog('yalova-2024-sosyal');
    $proje = function () {
        $f = sartFaaliyet('AB Çerçeve / Ufuk', Kategori::Proje, null);
        $f->rol = 'yurutucu';

        return $f;
    };

    expect($katalog->topla([$proje(), $proje(), $proje()], $katalog->coz(['7'])))->toBe(20);
});

test('Yalova yazar payında iki kuralın düşüğünü uyguluyor', function () {
    $depo = sartDepo();
    $yazarlar = fn (int $n) => implode(', ', array_map(fn (int $i) => "Y{$i}", range(1, $n)));

    $carpan = function (string $rol, int $n, Kategori $kategori = Kategori::Makale) use ($depo, $yazarlar): float {
        $f = sartFaaliyet($kategori === Kategori::Atif ? 'WoS / Scopus' : 'SCIE/SSCI (Q1)', $kategori, null);
        $f->rol = $rol;
        $f->yazarlar = $yazarlar($n);

        return $depo->katalog('yalova-2024-sosyal')->yazarCarpani($f);
    };

    // MADDE 10/4 makalede başlıca yazara 2 kişide 0,8 veriyor ama kitap ve
    // bildiride eşit bölüşme istiyor. Motor kategoriye göre ayrı tablo
    // tanımadığı için her rolde DÜŞÜK olan (eşit bölüşme) yazıldı.
    expect($carpan('tek', 1))->toBe(1.0)
        ->and($carpan('baslica', 2))->toBe(0.5)
        ->and($carpan('baslica', 4))->toBe(0.25)
        ->and($carpan('ilk', 5))->toBe(0.2);

    // İkinci ve sonraki yazarlar: 0,5 / (n - 1). İki yazarda yönergenin
    // verdiği 0,5'e eşit, üç ve sonrasında eşit bölüşmeden düşük.
    expect($carpan('yazar_2', 2))->toBe(0.5)
        ->and($carpan('yazar_2', 3))->toBe(0.25)
        ->and($carpan('ortak', 5))->toBe(0.125);

    // Yayın dışı kalemlerde yönerge sessiz; pay uygulanmıyor.
    expect($carpan('ortak', 5, Kategori::Atif))->toBe(1.0);
});

test('Yalova Sağlık tablosunun dipnot zorunluluklarını koşula çeviriyor', function () {
    $depo = sartDepo();
    $esik = $depo->bul('Yalova Üniversitesi', 'dr_ogr_uyesi', 'saglik');

    $q1 = fn () => sartFaaliyet('SCIE/SSCI (Q1)', tarih: '2024-01-01');
    $tr = fn () => sartFaaliyet('TR Dizin', tarih: '2024-01-01');

    // Üç Q1 makale kadro paragrafını (2 yayın + 50 puan) karşılıyor, ama
    // tablo dipnotları TR Dizin'den 10, tezden 1 yayın ve atıftan 4 puan
    // istiyor; üçü de eksik.
    $sonuc = $depo->degerlendir($esik, [$q1(), $q1(), $q1()], new Profil);

    expect(sartDugum($sonuc, 'EK-C · 2. bölüm dipnotu')->durum)->toBe(Durum::Saglanmadi)
        ->and(sartDugum($sonuc, 'EK-C · 3. bölüm dipnotu')->durum)->toBe(Durum::Saglanmadi)
        ->and(sartDugum($sonuc, 'EK-C · 5. bölüm dipnotu')->durum)->toBe(Durum::Saglanmadi);

    // TR Dizin makalesi 10 puan; tek yayın dipnotu açıyor.
    $sonuc = $depo->degerlendir($esik, [$q1(), $q1(), $tr()], new Profil);
    expect(sartDugum($sonuc, 'EK-C · 2. bölüm dipnotu')->durum)->toBe(Durum::Saglandi);
});

test('Yalova Mimarlık doçentliğinde tek yazarlı makale şart', function () {
    $depo = sartDepo();
    $esik = $depo->bul('Yalova Üniversitesi', 'docentlik', 'mimarlik');
    $profil = new Profil(doktoraTarihi: Carbon::parse('2018-01-01'));

    $makale = function (string $rol, string $kaynak = 'SCIE/SSCI (Q1)') {
        $f = sartFaaliyet($kaynak, tarih: '2022-01-01');
        $f->rol = $rol;
        $f->yazarlar = $rol === 'tek' ? 'Y1' : 'Y1, Y2';

        return $f;
    };

    // Ortak yazarlı makale koşulu açmıyor.
    expect(sartDugum($depo->degerlendir($esik, [$makale('baslica')], $profil), 'EK-Ç · 2')->durum)
        ->toBe(Durum::Saglanmadi);

    // Tek yazarlı makale açıyor.
    expect(sartDugum($depo->degerlendir($esik, [$makale('tek')], $profil), 'EK-Ç · 2')->durum)
        ->toBe(Durum::Saglandi);

    // 1ç bendi (diğer uluslararası indeks) koşulun dışında bırakılmış.
    expect(sartDugum($depo->degerlendir($esik, [$makale('tek', 'Diğer Hakemli Dergi')], $profil), 'EK-Ç · 2')->durum)
        ->toBe(Durum::Saglanmadi);
});

test('Yalova Mimarlık yarışma puanını yayınla telafi ediyor', function () {
    $depo = sartDepo();
    $esik = $depo->bul('Yalova Üniversitesi', 'docentlik', 'mimarlik');
    $ad = 'EK-Ç · 13. bölüm notu';

    $yarisma = fn () => sartFaaliyet('Sempozyum/Çalıştay/Bienal (Yurt Dışı)', Kategori::SanatselEtkinlik, null, '2022-01-01');
    $q1 = fn () => sartFaaliyet('SCIE/SSCI (Q1)', tarih: '2022-01-01');

    // Tek yarışma 15 puan; koşulu doğrudan sağlıyor.
    expect(sartDugum($depo->degerlendir($esik, [$yarisma()], new Profil), $ad)->durum)
        ->toBe(Durum::Saglandi);

    // Yarışması olmayan aday 1a-1c'den bir yayınla telafi ediyor.
    $telafili = sartDugum($depo->degerlendir($esik, [$q1()], new Profil), $ad);
    expect($telafili->durum)->toBe(Durum::Saglandi)
        ->and($telafili->telafiIleSaglandi())->toBeTrue();
});

test('Yalova profesörlüğü puanın beş ayrı maddeye dağılmasını istiyor', function () {
    $depo = sartDepo();
    $esik = $depo->bul('Yalova Üniversitesi', 'profesorluk', 'sosyal');
    $profil = new Profil(docentlikTarihi: Carbon::parse('2019-01-01'));
    $ad = 'en az BEŞ ayrı bölümünden';

    // Sekiz Q1 makale 160 puan eder ama hepsi tek maddeden; beş madde koşulu
    // açılmıyor.
    $q1 = fn () => sartFaaliyet('SCIE/SSCI (Q1)', tarih: '2022-01-01');
    $sadeceMakale = array_map($q1, range(1, 8));

    expect(sartDugum($depo->degerlendir($esik, $sadeceMakale, $profil), $ad)->durum)
        ->toBe(Durum::Saglanmadi);

    // Beş ayrı bölümden birer faaliyet koşulu açıyor.
    $dagilmis = [
        $q1(),
        sartFaaliyet('TR Dizin', tarih: '2022-01-01'),
        sartFaaliyet('Kitap Bölümü', Kategori::Kitap, null, '2022-01-01'),
        sartFaaliyet('WoS / Scopus', Kategori::Atif, null, '2022-01-01'),
        sartFaaliyet('Lisansüstü Ders', Kategori::EgitimOgretim, null, '2022-01-01'),
    ];

    expect(sartDugum($depo->degerlendir($esik, $dagilmis, $profil), $ad)->durum)
        ->toBe(Durum::Saglandi);
});

test('Bayburt güzel sanatlar alt barajı sanat etkinliklerini de sayıyor', function () {
    $depo = sartDepo();

    // 11(2) bölümü okunana kadar bu alan hiç girilmemişti.
    $gs = $depo->bul('Bayburt Üniversitesi', 'dr_ogr_uyesi', 'guzel_sanatlar');
    expect($gs)->not->toBeNull()
        ->and($gs['anahtar'])->toBe('bayburt-gs-dr-guzel_sanatlar');

    $ad = 'Makale, kitap, bildiri, proje, patent, atıf ve sanat etkinliği kalemlerinizden en az 80 puan';

    // Tek yurt dışı kişisel sergi = 80 puan (11.2.1.a) ve alt barajı tam dolduruyor.
    $sergi = [sartFaaliyet('Kişisel Etkinlik (Uluslararası)', Kategori::SanatselEtkinlik)];

    expect(sartDugum($depo->degerlendir($gs, $sergi, new Profil), $ad)->mevcut)->toBe(80);

    // Aynı faaliyet öteki alanların "1-6" kümesine GİRMİYOR; sanat bölümü o
    // kümenin dışında. Alt baraj orada sıfır kalıyor.
    $genel = $depo->bul('Bayburt Üniversitesi', 'dr_ogr_uyesi', 'sosyal');
    $genelAd = 'Makale, kitap, bildiri, proje, patent ve atıf kalemlerinizden en az 80 puan';

    expect(sartDugum($depo->degerlendir($genel, $sergi, new Profil), $genelAd)->mevcut)->toBe(0);
});

test('Bayburt sanat cetvelinde aynı etikete düşen çiftlerde düşük değer geçerli', function () {
    $katalog = (new SartDeposu)->katalog('bayburt-2024');

    // Kaynakta 11.2.7.a 60 / 11.2.7.b 30 puan; ikisi de tek "Koruma-Onarım
    // Uygulaması (Uluslararası)" etiketine düşüyor, §0 uyarınca 30 girildi.
    // Aynı biçimde 11.2.10.j (80) yerine 11.2.10.k (60) yazıldı.
    $puanlar = [];
    foreach (['11.2.7.b', '11.2.7.ç', '11.2.9.c', '11.2.10.e', '11.2.10.k'] as $kod) {
        $puanlar[$kod] = $katalog->maddePuani($kod);
    }

    expect($puanlar)->toBe([
        '11.2.7.b' => 30,
        '11.2.7.ç' => 15,
        '11.2.9.c' => 20,
        '11.2.10.e' => 30,
        '11.2.10.k' => 60,
    ]);

    // Yüksek değerli eşleri hiç yazılmadı; yazılsaydı aday fazla puan görürdü.
    foreach (['11.2.7.a', '11.2.7.c', '11.2.9.a', '11.2.10.d', '11.2.10.j'] as $kod) {
        expect($katalog->coz([$kod]))->toBeEmpty("Fazla sayan satır girilmiş: {$kod}");
    }
});

test('Kilis sanat barajı çizelgenin yalnızca sayılan bölümlerini topluyor', function () {
    $depo = sartDepo();

    // 9-33 arası bölümler okunana kadar bu alan hiç girilmemişti.
    $esik = $depo->bul('Kilis 7 Aralık Üniversitesi', 'dr_ogr_uyesi', 'guzel_sanatlar');
    expect($esik)->not->toBeNull()
        ->and($esik['anahtar'])->toBe('kilis-dr-sanat-guzel_sanatlar');

    $ad = 'Sergi, koleksiyon, müzik, film, sahne ve tasarım kalemlerinizden en az 50 puan';
    $sanat = fn (string $kaynak) => sartFaaliyet($kaynak, Kategori::SanatselEtkinlik);

    // 9.b (20) + 12.a (25) + 13.a (20) = 65 → baraj doluyor.
    $sonuc = $depo->degerlendir($esik, [
        $sanat('Kişisel Etkinlik (Uluslararası)'),
        $sanat('Opera/Bale Kompozisyonu'),
        $sanat('Uzun Metrajlı Film / Belgesel (Ulusal)'),
    ], new Profil);

    expect(sartDugum($sonuc, $ad)->mevcut)->toBe(65)
        ->and(sartDugum($sonuc, $ad)->durum)->toBe(Durum::Saglandi);

    // Madde 7/3-c 22 ve 23 numaralı bölümleri SAYMIYOR: sanatsal ödül ve
    // yarışma jüriliği puanı bu barajı doldurmaz.
    $odul = sartFaaliyet('Uluslararası Bilim/Sanat Ödülü', Kategori::Odul);
    expect(sartDugum($depo->degerlendir($esik, [$odul], new Profil), $ad)->mevcut)->toBe(0);
});

test('Kilis 34. bölümün ödül ve patent puanları kaynaktaki değerlerde', function () {
    $katalog = (new SartDeposu)->katalog('kilis-2019');

    // Çizelge: uluslararası bilim ödülü 40 · ulusal bilim ödülü 25 ·
    // yabancı patent 20 · ulusal patent ya da çeşit tescili 10.
    // Cetvelde patentler 30 ve 20 ile FAZLA, ödüller tek satırda 10 ile EKSİK yazılıydı.
    expect($katalog->maddePuani('34.a'))->toBe(40)
        ->and($katalog->maddePuani('34.b'))->toBe(25)
        ->and($katalog->maddePuani('34.c'))->toBe(20)
        ->and($katalog->maddePuani('34.ç'))->toBe(10);

    // Sanatsal ödül (22, düşük) ile bilim ödülü (34, yüksek) kayıtta ayrılamıyor;
    // genel ödül etiketleri §0 uyarınca 22'nin değerlerinden sayılıyor.
    $puan = fn (string $kaynak) => $katalog->puan(
        sartFaaliyet($kaynak, Kategori::Odul),
        ['22.a', '22.b', '34.a', '34.b'],
    );

    expect($puan('Uluslararası Bilim/Sanat Ödülü'))->toBe(20)
        ->and($puan('Ulusal Bilim/Sanat Ödülü'))->toBe(5)
        ->and($puan('TÜBİTAK / TÜBA Ödülü'))->toBe(25);
});

test('Osmaniye sanat ve idari görev kademeleri tabloya göre ayrışıyor', function () {
    $katalog = (new SartDeposu)->katalog('osmaniye-2023');

    // 10.1.1 ve 10.1.2 "puan sütunu ayrıştırılamadı" diye girilmemişti;
    // etiketleri 10.1.3'e (40) yığılmıştı.
    $sanat = fn (string $kaynak) => $katalog->puan(
        sartFaaliyet($kaynak, Kategori::SanatselEtkinlik),
        $katalog->coz(['10.*']),
    );

    expect($sanat('Kişisel Etkinlik (Uluslararası)'))->toBe(60)
        ->and($sanat('Karma/Jürili Etkinlik (Uluslararası)'))->toBe(40)
        ->and($sanat('Kişisel Etkinlik (Ulusal)'))->toBe(30)
        // Jürisiz karma katılım tabloda en alt satır (10 ve 5); önce 20 ve 10 sayılıyordu.
        ->and($sanat('Karma Etkinlik (Yurt Dışı, Jürisiz)'))->toBe(10)
        ->and($sanat('Karma Etkinlik (Jürisiz, Ulusal)'))->toBe(5)
        // İcracı kalemleri 10.1.5/10.2.5'in tanımına giriyor, 10.1.3'ün değil.
        ->and($sanat('Resital (Uluslararası)'))->toBe(20)
        ->and($sanat('Resital (Ulusal)'))->toBe(10);

    // 12. bölüm beş kademeli; hepsi 12.2'de (15) toplanmıştı.
    $idari = fn (string $kaynak) => $katalog->puan(
        sartFaaliyet($kaynak, Kategori::IdariGorev),
        $katalog->coz(['12.*']),
    );

    expect($idari('Rektör'))->toBe(20)
        ->and($idari('Dekan / Enstitü-YO Müdürü'))->toBe(15)
        ->and($idari('Bölüm Başkanı'))->toBe(10)
        ->and($idari('Bölüm Başkan Yardımcısı'))->toBe(5)
        ->and($idari('Anabilim Dalı Başkanı / Koordinatörlük'))->toBe(1);
});

test('Hatay MKÜ patentleri puanlıyor, ödül satırları düşük kademeden sayılıyor', function () {
    $katalog = (new SartDeposu)->katalog('hatay-mku-2024');

    // E2 "puan satırları ayrıştırılamadı" diye girilmemişti: patenti olan aday SIFIR görüyordu.
    $patent = fn (string $kaynak) => $katalog->puan(
        sartFaaliyet($kaynak, Kategori::Patent),
        $katalog->coz(['E*']),
    );

    expect($patent('Uluslararası Patent'))->toBe(50)
        ->and($patent('Ulusal Patent'))->toBe(25)
        ->and($patent('Islahçı Hakkı / Çeşit Tescili'))->toBe(50);

    // E1b (50) ile E1d (15), E1c (25) ile E1e (10) kayıtta ayrılamıyor; §0 uyarınca düşükten.
    $odul = fn (string $kaynak) => $katalog->puan(
        sartFaaliyet($kaynak, Kategori::Odul),
        $katalog->coz(['E*']),
    );

    expect($odul('Uluslararası Bilim/Sanat Ödülü'))->toBe(15)
        ->and($odul('Ulusal Bilim/Sanat Ödülü'))->toBe(10)
        // Kendi etiketi olan ödüller kendi satırlarında kalıyor.
        ->and($odul('Ufuk Avrupa / ERC Ödülü'))->toBe(50)
        ->and($odul('YÖK Ödülü'))->toBe(60);
});

test('İstanbul Ticaret tez ve jüri satırlarında tavan değil satır puanı sayıyor', function () {
    $depo = sartDepo();
    $katalog = $depo->katalog('istanbul-ticaret-2019');

    // Kaynakta doktora tezi 10, yüksek lisans 5 puan; 75 bölümün TOPLAM sınırı.
    // Cetvelde satır değeri olarak 75 yazılıydı: iki tez yöneten aday 150 görüyordu.
    $tez = fn (string $kaynak, string $rol) => $katalog->puan(
        sartFaaliyet($kaynak, Kategori::TezDanismanligi, $rol),
        $katalog->coz(['II.B.*']),
    );

    expect($tez('Doktora Tezi', 'danisman'))->toBe(10)
        ->and($tez('Yüksek Lisans Tezi', 'danisman'))->toBe(5)
        // II/B-3: ikinci danışmanlıkta puanın yarısı.
        ->and($tez('Doktora Tezi', 'es_danisman'))->toBe(5)
        // Jüri türü kayıtta yok; doktora 3, yüksek lisans 2 → §0 uyarınca 2.
        ->and($tez('Tez İzleme / Jüri Üyeliği', 'danisman'))->toBe(2);

    // Tavan artık uygulanıyor: on doktora tezi 100 değil 75 puan.
    $tezler = array_fill(0, 10, sartFaaliyet('Doktora Tezi', Kategori::TezDanismanligi, 'danisman'));
    expect($katalog->topla($tezler, $katalog->coz(['II.B.1'])))->toBe(75);
});

test('İstanbul Ticaret editörlük kademelerini dergi düzeyine göre ayırıyor', function () {
    $katalog = (new SartDeposu)->katalog('istanbul-ticaret-2019');

    // Bütün editörlük etiketleri tek satırda 120 puanla toplanmıştı: bir hakemlik
    // kaydı olan aday 120 puan görüyordu.
    $ed = fn (string $kaynak) => $katalog->puan(
        sartFaaliyet($kaynak, Kategori::Editorluk),
        $katalog->coz(['I.D.5.*']),
    );

    expect($ed('WoS Dergi (Q1)'))->toBe(120)
        ->and($ed('ESCI / Scopus Dergi'))->toBe(70)
        ->and($ed('TR Dizin Dergi'))->toBe(25)
        ->and($ed('Diğer Hakemli Dergi'))->toBe(20)
        // Yardımcı editörlük yarısı, hakemlik beşte biri; dergi düzeyi kayıtta
        // olmadığı için en düşük editörlük satırından (20) hesaplandı.
        ->and($ed('Yayın Kurulu Üyeliği'))->toBe(10)
        ->and($ed('Hakemlik'))->toBe(4);

    // Atıf ve patent de kademeli.
    expect($katalog->puan(sartFaaliyet('WoS / Scopus', Kategori::Atif), $katalog->coz(['I.D.6.*'])))->toBe(10)
        ->and($katalog->puan(sartFaaliyet('Diğer', Kategori::Atif), $katalog->coz(['I.D.6.*'])))->toBe(2)
        ->and($katalog->puan(sartFaaliyet('Uluslararası Patent', Kategori::Patent), $katalog->coz(['II.D.7.*'])))->toBe(50)
        ->and($katalog->puan(sartFaaliyet('Ulusal Patent', Kategori::Patent), $katalog->coz(['II.D.7.*'])))->toBe(20);
});

test('Kahramanmaraş İstiklal proje puanını role göre ayırıyor', function () {
    $katalog = (new SartDeposu)->katalog('kahramanmaras-istiklal-2024');

    // A5 satırları rolsüzdü: projede bursiyer olan aday yürütücü puanını alıyordu.
    $proje = fn (string $kaynak, string $rol) => $katalog->puan(
        sartFaaliyet($kaynak, Kategori::Proje, $rol),
        $katalog->coz(['A5.*']),
    );

    expect($proje('AB Çerçeve / Ufuk', 'yurutucu'))->toBe(40)
        ->and($proje('AB Çerçeve / Ufuk', 'arastirmaci'))->toBe(20)
        ->and($proje('AB Çerçeve / Ufuk', 'danisman'))->toBe(15)
        ->and($proje('AB Çerçeve / Ufuk', 'bursiyer'))->toBe(10)
        ->and($proje('TÜBİTAK', 'yurutucu'))->toBe(30)
        ->and($proje('TÜBİTAK', 'bursiyer'))->toBe(6)
        ->and($proje('BAP (Üniversite)', 'bursiyer'))->toBe(5);

    // A6.6 editörlüğü, kurul üyeliğini ve hakemliği 10 puanla topluyordu.
    $ed = fn (string $kaynak) => $katalog->puan(
        sartFaaliyet($kaynak, Kategori::Editorluk),
        $katalog->coz(['A6.*']),
    );

    expect($ed('TR Dizin Dergi'))->toBe(10)
        ->and($ed('Yayın Kurulu Üyeliği'))->toBe(3)
        ->and($ed('Hakemlik'))->toBe(2)
        ->and($ed('BKCI Kitap'))->toBe(40);

    // A6 bölüm tavanı (50) uygulanıyor: iki SCI editörlüğü 80 değil 50.
    $editorlukler = array_fill(0, 2, sartFaaliyet('WoS Dergi (Q1)', Kategori::Editorluk));
    expect($katalog->topla($editorlukler, $katalog->coz(['A6'])))->toBe(50);
});

test('İzmir Kavram ders puanını görev süresine bağlı olduğu için saymıyor', function () {
    $katalog = (new SartDeposu)->katalog('izmir-kavram-2025');

    // 17. madde metin katmanında "2 ders … olmak" görünüyordu ve ders BAŞINA
    // 2 puan girilmişti; sayfa görüntüsünde madde "2 YIL ders vermiş olmak"
    // diyor. Bir dönemde dört ders veren aday 6 puanlık tavanı dolduruyordu.
    $dersler = array_fill(0, 4, sartFaaliyet('Lisans/Önlisans Ders', Kategori::EgitimOgretim));

    expect($katalog->topla($dersler, $katalog->coz(['TUM'])))->toBe(0);

    // 2.c ve 2.d başlıkları görüntüden doğrulandı; değerler değişmedi.
    expect($katalog->maddePuani('2c'))->toBe(15)
        ->and($katalog->maddePuani('2d'))->toBe(10);
});

test('Ordu tablo dipnotunun tek yazar koşulu doğru kadroya bağlanıyor', function () {
    $depo = sartDepo();
    $profil = new Profil(
        doktoraTarihi: Carbon::parse('2010-01-01'),
        docentlikTarihi: Carbon::parse('2018-01-01'),
        yds: 70,
    );

    // Dipnot bağlanması üst simgeden okunuyor: (3) doçentliğe, (4) profesörlüğe.
    // Filoloji'de doçentlik 1, profesörlük 2 tek yazarlı yayın istiyor.
    $docent = $depo->bul('Ordu Üniversitesi', 'docentlik', 'filoloji');
    $profesor = $depo->bul('Ordu Üniversitesi', 'profesorluk', 'filoloji');

    $ad = 'tek yazar olmalısınız';
    expect(sartDugum($depo->degerlendir($docent, [], $profil), $ad)->gerekli)->toBe(1)
        ->and(sartDugum($depo->degerlendir($profesor, [], $profil), $ad)->gerekli)->toBe(2);

    // Tek yazarlı bir yayın doçentlik koşulunu sağlıyor, çok yazarlı sağlamıyor.
    $tek = sartFaaliyet('TR Dizin', tarih: '2015-01-01');
    $ortak = sartFaaliyet('TR Dizin', yazarRolu: 'yazar_2', tarih: '2015-01-01');

    expect(sartDugum($depo->degerlendir($docent, [$tek], $profil), $ad)->durum)->toBe(Durum::Saglandi)
        ->and(sartDugum($depo->degerlendir($docent, [$ortak], $profil), $ad)->mevcut)->toBe(0);

    // Fen'de dipnot tek yazar değil BİRİNCİ İSİM istiyor; kaynak doçentlikte
    // profesörlükten fazlasını arıyor (2'ye 1) ve olduğu gibi girildi.
    $fenAd = 'birinci isim ya da sorumlu yazar olmalısınız';
    expect(sartDugum($depo->degerlendir($depo->bul('Ordu Üniversitesi', 'docentlik', 'fen'), [], $profil), $fenAd)->gerekli)->toBe(2)
        ->and(sartDugum($depo->degerlendir($depo->bul('Ordu Üniversitesi', 'profesorluk', 'fen'), [], $profil), $fenAd)->gerekli)->toBe(1);

    // Dipnotu olmayan tablolarda satır hiç görünmüyor.
    $muh = $depo->degerlendir($depo->bul('Ordu Üniversitesi', 'docentlik', 'muhendislik'), [], $profil);
    expect($muh->topla(fn ($d) => str_contains($d->aciklama, 'tek yazar olmalısınız')))->toBeEmpty();
});

test('proje satırları rol ayrımını koruyor', function () {
    $depo = sartDepo();
    $puan = function (string $cetvel, string $kaynak, string $rol) use ($depo): int {
        $k = $depo->katalog($cetvel);

        return $k->puan(sartFaaliyet($kaynak, Kategori::Proje, $rol), $k->coz(['*']));
    };

    // Adıyaman J bölümünün üç satırı da yürütücü/araştırmacı diye ayrılıyor;
    // cetvel rol ayrımı yapmıyordu, araştırmacı yürütücü puanını alıyordu.
    expect($puan('adiyaman-2024', 'AB Çerçeve / Ufuk', 'yurutucu'))->toBe(250)
        ->and($puan('adiyaman-2024', 'AB Çerçeve / Ufuk', 'arastirmaci'))->toBe(100)
        ->and($puan('adiyaman-2024', 'TÜBİTAK', 'yurutucu'))->toBe(200)
        ->and($puan('adiyaman-2024', 'TÜBİTAK', 'arastirmaci'))->toBe(75);

    // Çukurova EK 2'nin tanım bölümü fon kuruluşlarını sayıyor; üniversite BAP'ı
    // ve özel sektör listede yok, satırdan çıkarıldı.
    expect($puan('cukurova-2024', 'TÜBİTAK', 'yurutucu'))->toBe(90)
        ->and($puan('cukurova-2024', 'BAP (Üniversite)', 'yurutucu'))->toBe(0)
        ->and($puan('cukurova-2024', 'Özel Sektör / STK', 'yurutucu'))->toBe(0);
});

test('küçük görevler bölümün en yüksek satırından sayılmıyor', function () {
    $depo = sartDepo();
    $p = function (string $cetvel, string $kaynak, Kategori $kat) use ($depo): int {
        $k = $depo->katalog($cetvel);

        return $k->puan(sartFaaliyet($kaynak, $kat), $k->coz(['*']));
    };

    // Adıyaman: yayın kurulu üyeliği 40/30/20 kademeli, en düşükten;
    // kitap editörlüğü 100/60/50/40 kademeli, Türkçe kitap satırından.
    expect($p('adiyaman-2024', 'Yayın Kurulu Üyeliği', Kategori::Editorluk))->toBe(20)
        ->and($p('adiyaman-2024', 'Kitap Editörlüğü', Kategori::Editorluk))->toBe(50)
        // Burs iki kademeli (yurt dışı 150 / yurt içi 75) → düşükten.
        ->and($p('adiyaman-2024', 'Burs', Kategori::Odul))->toBe(75);

    // Başkent'in kriter listesinde burs satırı yok; jürili ulusal ödül puanı almıyor.
    expect($p('baskent-2024', 'Burs', Kategori::Odul))->toBe(0)
        // 13. madde "kitap editörlüğü veya KİTAP çevirisi"; bölüm çevirisi satırı yok.
        ->and($p('baskent-2024', 'Çeviri Kitap', Kategori::Kitap))->toBe(100)
        ->and($p('baskent-2024', 'Çeviri Kitap Bölümü', Kategori::Kitap))->toBe(0);

    // Eskişehir Teknik 12ç iki kademeli (yöneticilik 80, yardımcılık 60) ve
    // dipnotu anabilim dalı başkanlıklarını kapsam dışı bırakıyor.
    expect($p('eskisehir-teknik-2026', 'Rektör', Kategori::IdariGorev))->toBe(80)
        ->and($p('eskisehir-teknik-2026', 'Rektör Yardımcısı', Kategori::IdariGorev))->toBe(60)
        ->and($p('eskisehir-teknik-2026', 'Anabilim Dalı Başkanı / Koordinatörlük', Kategori::IdariGorev))->toBe(0)
        ->and($p('eskisehir-teknik-2026', 'Kurul / Komisyon Üyeliği', Kategori::IdariGorev))->toBe(0);

    // Iğdır 26. madde ödülü "(TÜBİTAK/TÜBA vb.)" sınıfına bağlı; yarışma derecesi 300 almaz.
    expect($p('igdir-2023', 'Yarışma Derecesi / Mansiyon', Kategori::Odul))->toBe(0);
});

test('proje rol kademeleri üç cetvelde daha kaynağa uyuyor', function () {
    $depo = sartDepo();
    $p = function (string $cetvel, string $kaynak, string $rol) use ($depo): int {
        $k = $depo->katalog($cetvel);

        return $k->puan(sartFaaliyet($kaynak, Kategori::Proje, $rol), $k->coz(['*']));
    };

    // Amasya D bölümü dört role ayrılıyor; cetvel tek satırdı, bursiyer de
    // yürütücü puanı alıyordu.
    expect($p('amasya-2024', 'AB Çerçeve / Ufuk', 'yurutucu'))->toBe(150)
        ->and($p('amasya-2024', 'AB Çerçeve / Ufuk', 'arastirmaci'))->toBe(50)
        ->and($p('amasya-2024', 'AB Çerçeve / Ufuk', 'danisman'))->toBe(25)
        ->and($p('amasya-2024', 'AB Çerçeve / Ufuk', 'bursiyer'))->toBe(10);

    // Artvin: E grubunun puanları cetvelde 40/25/10 yazılıydı, kaynakta
    // 100/…/30; grup başlığı ayrıca araştırmacıya %70, danışmana %30,
    // bursiyere %15 veriyor.
    expect($p('artvin-2024', 'AB Çerçeve / Ufuk', 'yurutucu'))->toBe(100)
        ->and($p('artvin-2024', 'AB Çerçeve / Ufuk', 'arastirmaci'))->toBe(70)
        ->and($p('artvin-2024', 'AB Çerçeve / Ufuk', 'danisman'))->toBe(30)
        ->and($p('artvin-2024', 'AB Çerçeve / Ufuk', 'bursiyer'))->toBe(15);

    // Artvin patentleri E grubunda tek 30 puanlık satırdaydı; kaynakta ayrı
    // bir J grubu ve üç kademeli.
    $ka = $depo->katalog('artvin-2024');
    expect($ka->puan(sartFaaliyet('Uluslararası Patent', Kategori::Patent), $ka->coz(['*'])))->toBe(100)
        ->and($ka->puan(sartFaaliyet('Ulusal Patent', Kategori::Patent), $ka->coz(['*'])))->toBe(50);

    // GİBTÜ'de altı fon kademesi ve iki rol vardı, üçü tek 20 puanlık satırdaydı.
    expect($p('gibtu-2024', 'AB Çerçeve / Ufuk', 'yurutucu'))->toBe(50)
        ->and($p('gibtu-2024', 'AB Çerçeve / Ufuk', 'arastirmaci'))->toBe(30)
        ->and($p('gibtu-2024', 'BAP (Üniversite)', 'yurutucu'))->toBe(10);
});

test('küçük kalemler kendi kaynak satırlarından sayılıyor — üçüncü parti', function () {
    $depo = sartDepo();
    $p = function (string $cetvel, string $kaynak, Kategori $kat, ?string $rol = 'tek') use ($depo): int {
        $k = $depo->katalog($cetvel);

        return $k->puan(sartFaaliyet($kaynak, $kat, $rol), $k->coz(['*']));
    };

    // Muşku: 15. fıkra yarışma derecesini tablo puanına oranlıyor (birincilik
    // tam, ikincilik %50, üçüncülük %25); derece kayıtta yok → %25.
    // Burs satırı yalnız EK-3'te var (ulusal 50) ve ana tabloda yok.
    expect($p('musku-2013-fen', 'Yarışma Derecesi / Mansiyon', Kategori::Odul))->toBe(25)
        ->and($p('musku-2013-fen', 'Burs', Kategori::Odul))->toBe(0)
        ->and($p('musku-2013-gsf', 'Burs', Kategori::Odul))->toBe(50);

    // Ataşehir Adıgüzel 26. madde de "(TÜBİTAK/TÜBA vb.)" sınıfına bağlı.
    expect($p('atasehir-adiguzel-2018', 'Yarışma Derecesi / Mansiyon', Kategori::Odul))->toBe(0);

    // Amasya B.4 bölüm çevirisi ayrı satır (20), kitap çevirisi 75.
    expect($p('amasya-2024', 'Çeviri Kitap', Kategori::Kitap))->toBe(75)
        ->and($p('amasya-2024', 'Çeviri Kitap Bölümü', Kategori::Kitap))->toBe(20);

    // Sakarya UBÜ: BAP 40, özel kuruluş 40, diğer kamu 80 — üçü 80'de toplanmıştı.
    expect($p('sakarya-ubu-2024', 'BAP (Üniversite)', Kategori::Proje, 'yurutucu'))->toBe(40)
        ->and($p('sakarya-ubu-2024', 'Özel Sektör / STK', Kategori::Proje, 'yurutucu'))->toBe(40)
        ->and($p('sakarya-ubu-2024', 'Diğer Kamu Kurumu', Kategori::Proje, 'yurutucu'))->toBe(80);

    // Kocaeli: 2209 danışmanlığı 10 puan; BAP role göre 18/6/3.
    expect($p('kocaeli-2023', 'Öğrenci Projesi (2209 vb.)', Kategori::Proje, 'danisman'))->toBe(10)
        ->and($p('kocaeli-2023', 'BAP (Üniversite)', Kategori::Proje, 'yurutucu'))->toBe(18)
        ->and($p('kocaeli-2023', 'BAP (Üniversite)', Kategori::Proje, 'danisman'))->toBe(3);
});

test('Sakarya UBÜ proje koşulu yönergenin saydığı dört kalemle sınırlı', function () {
    $katalog = (new SartDeposu)->katalog('sakarya-ubu-2024');
    $kodlar = $katalog->coz(['4.1-4.4']);

    // BAP ve özel kuruluş projeleri koşulu SAĞLAMAMALI: yönerge "4.1, 4.2, 4.3,
    // 4.4 proje faaliyetlerinden" diyor, bu ikisi 4.6 ve 4.7.
    expect($katalog->eslesir(sartFaaliyet('BAP (Üniversite)', Kategori::Proje, 'yurutucu'), $kodlar))->toBeFalse()
        ->and($katalog->eslesir(sartFaaliyet('Özel Sektör / STK', Kategori::Proje, 'yurutucu'), $kodlar))->toBeFalse()
        ->and($katalog->eslesir(sartFaaliyet('AB Çerçeve / Ufuk', Kategori::Proje, 'yurutucu'), $kodlar))->toBeTrue();
});

test('kuyruk taraması: küçük kalemler kendi kademelerinde', function () {
    $depo = sartDepo();
    $p = function (string $cetvel, string $kaynak, Kategori $kat) use ($depo): int {
        $k = $depo->katalog($cetvel);

        return $k->puan(sartFaaliyet($kaynak, $kat), $k->coz(['*']));
    };

    // Marmara'nın her alan tablosunda hakemlik ve burs uluslararası/ulusal diye
    // ikiye ayrılıyor (10/5 ve 30/10); kayıt düzeyi taşımıyor → ulusalden.
    foreach (['marmara-fen-saglik', 'marmara-sosyal', 'marmara-spor'] as $cetvel) {
        expect($p($cetvel, 'Hakemlik', Kategori::Editorluk))->toBe(5)
            ->and($p($cetvel, 'Burs', Kategori::Odul))->toBe(10);
    }

    // İnönü: bölüm başkan yardımcılığı kaynakta puanlanmıyor; anabilim dalı
    // başkanlığı ile koordinatörlük tek etikette (30/20) → düşükten.
    expect($p('inonu-2026', 'Bölüm Başkan Yardımcısı', Kategori::IdariGorev))->toBe(0)
        ->and($p('inonu-2026', 'Anabilim Dalı Başkanı / Koordinatörlük', Kategori::IdariGorev))->toBe(20);

    // Düzce: proje/yarışma ödülü ayrı ve düşük satır (ulusal 10), bilim ödülü 30.
    expect($p('duzce-2024', 'Yarışma Derecesi / Mansiyon', Kategori::Odul))->toBe(10)
        ->and($p('duzce-2024', 'Ulusal Bilim/Sanat Ödülü', Kategori::Odul))->toBe(30);

    // Burs satırı olmayan üç kaynakta burs puan üretmiyor.
    expect($p('hakkari-2024', 'Burs', Kategori::Odul))->toBe(0)
        ->and($p('sirnak-2024', 'Burs', Kategori::Odul))->toBe(0)
        ->and($p('istanbul-29-mayis-2017', 'Burs', Kategori::Odul))->toBe(0);

    // İstanbul Zaim: bölüm başkan yardımcılığı Y.2'nin listesinde yok, Y.3'ün
    // "vb. görevler" kovasında.
    expect($p('istanbul-zaim-2019', 'Bölüm Başkan Yardımcısı', Kategori::IdariGorev))->toBe(5);

    // İTÜ'nün "ulusal projeler" tanımı 2209 öğrenci projesini saymıyor.
    $itu = $depo->katalog('itu-2022');
    expect($itu->puan(sartFaaliyet('Öğrenci Projesi (2209 vb.)', Kategori::Proje, 'yurutucu'), $itu->coz(['*'])))->toBe(0)
        ->and($itu->puan(sartFaaliyet('BAP (Üniversite)', Kategori::Proje, 'yurutucu'), $itu->coz(['*'])))->toBe(25);
});

test('Dokuz Eylül yarışma ödülü kendi maddesinden sayılıyor', function () {
    $depo = sartDepo();
    $katalog = $depo->katalog('dokuz-eylul-2024');

    // Yarışma ödülü 18.b.1'in (sürekli ve periyodik jürili ulusal ödül, 15)
    // etiketlerine bağlıydı; kaynağın 37. maddesi bunu ayrı ve düşük puanlıyor.
    expect($katalog->puan(sartFaaliyet('Yarışma Derecesi / Mansiyon', Kategori::Odul), $katalog->coz(['*'])))->toBe(10)
        ->and($katalog->puan(sartFaaliyet('Ulusal Bilim/Sanat Ödülü', Kategori::Odul), $katalog->coz(['*'])))->toBe(15);

    // Konservatuvar koşulu ("yarışma, festival veya bienalden ödül") artık
    // 37. maddeye bağlı; bir bilim ödülü onu SAĞLAMAMALI.
    $esik = $depo->bul('Dokuz Eylül Üniversitesi', 'dr_ogr_uyesi', 'guzel_sanatlar',
        'Konservatuvar — Dans ve Koreografi');
    $ad = 'Yarışma, festival veya bienalden ödül almış olmak';

    expect(sartDugum($depo->degerlendir($esik, [sartFaaliyet('Yarışma Derecesi / Mansiyon', Kategori::Odul)], new Profil), $ad)->durum)
        ->toBe(Durum::Saglandi)
        ->and(sartDugum($depo->degerlendir($esik, [sartFaaliyet('TÜBİTAK / TÜBA Ödülü', Kategori::Odul)], new Profil), $ad)->mevcut)
        ->toBe(0);
});

test('MSGSÜ koordinatörlük idari görev satırından sayılmıyor', function () {
    $katalog = (new SartDeposu)->katalog('msgsu-2023');
    $p = fn (string $k) => $katalog->puan(sartFaaliyet($k, Kategori::IdariGorev), $katalog->coz(['*']));

    // Etiket anabilim dalı başkanlığını (6.5.1, 10) koordinatörlükle (6.6, 1-3)
    // birleştiriyor; kayıt süreyi taşımadığı için en düşükten.
    expect($p('Anabilim Dalı Başkanı / Koordinatörlük'))->toBe(1)
        ->and($p('Rektör'))->toBe(10);
});

test('Çukurova bildiri ve diğer yayınevi kitabı tavanları uygulanıyor', function () {
    $katalog = (new SartDeposu)->katalog('cukurova-2024');
    $tumu = $katalog->coz(['*']);

    // EK 2'nin tanım bölümü: "Bildiri kategorisinde en fazla 30 puan
    // alınabilir." Dört CPCI bildirisi tavansız 60 ederdi.
    $bildiriler = array_fill(0, 4, sartFaaliyet('Uluslararası Tam Metin (CPCI)', Kategori::Bildiri));
    expect($katalog->topla($bildiriler, $tumu))->toBe(30);

    // Tavan yalnız "diğer yayınevi" kademesinde: üç kitap 90 yerine 30, ama
    // BKCI kitabı sınırsız (üç tane 180).
    $diger = array_fill(0, 3, sartFaaliyet('Uluslararası/Ulusal Kitap', Kategori::Kitap));
    $bkci = array_fill(0, 3, sartFaaliyet('BKCI / Scopus Kitap', Kategori::Kitap));
    expect($katalog->topla($diger, $tumu))->toBe(30)
        ->and($katalog->topla($bkci, $tumu))->toBe(180);
});

test('Akdeniz bölüm tavanları uygulanıyor', function () {
    $katalog = (new SartDeposu)->katalog('akdeniz-2026');
    $tumu = $katalog->coz(['*']);

    // 3. bölüm iki katmanlı: 3.2+3.3 en fazla 120, bölüm toplamı en fazla 250.
    // Kırk kitap atfı (4 puan) tavansız 160 ederdi.
    expect($katalog->topla(array_fill(0, 40, sartFaaliyet('BKCI Kitap', Kategori::Atif)), $tumu))->toBe(120);

    // Alt tavan 3.1'i kapsamıyor: yüz WoS atfı 500 değil, bölüm tavanı 250.
    expect($katalog->topla(array_fill(0, 100, sartFaaliyet('WoS / Scopus', Kategori::Atif)), $tumu))->toBe(250);

    // 4. bölüm 200: iki uluslararası patent tavansız 500 ederdi.
    expect($katalog->topla(array_fill(0, 2, sartFaaliyet('Uluslararası Patent', Kategori::Patent)), $tumu))->toBe(200);

    // 7. bölüm 20: on CPCI bildirisi (8 puan) tavansız 80 ederdi.
    expect($katalog->topla(array_fill(0, 10, sartFaaliyet('Uluslararası Tam Metin (CPCI)', Kategori::Bildiri)), $tumu))->toBe(20);
});

test('Fırat çapraz tablo tavanları ve BAP tavanı uygulanıyor', function () {
    $depo = sartDepo();
    $katalog = $depo->katalog('firat-2026');
    $tumu = $katalog->coz(['*']);

    // "A5+B4 toplamı en fazla 300": yüz WoS atfı (5) tavansız 500 ederdi.
    expect($katalog->topla(array_fill(0, 100, sartFaaliyet('WoS / Scopus', Kategori::Atif)), $tumu))->toBe(300);

    // "A6+B5 toplamı en fazla 50": beş WoS editörlüğü (30) tavansız 150.
    expect($katalog->topla(array_fill(0, 5, sartFaaliyet('WoS Dergi (Q1)', Kategori::Editorluk)), $tumu))->toBe(50);

    // Asıl kazanç KOŞULDA: "C2-C6 kapsamında toplamda en az 30 puan" barajı
    // altı BAP projesiyle (6×5) sahte biçimde sağlanıyordu; tavan 10.
    $bap = array_fill(0, 6, sartFaaliyet('BAP (Üniversite)', Kategori::Proje, 'yurutucu'));
    expect($katalog->topla($bap, $katalog->coz(['C2-C6'])))->toBe(10);
});

test('Sakarya madde ve bölüm tavanları uygulanıyor', function () {
    $katalog = (new SartDeposu)->katalog('sakarya-2026');
    $tumu = $katalog->coz(['*']);

    // "1.3 yayınları için toplamda en fazla 60 puan": TR Dizin makalesi 25,
    // beş tane tavansız 125 ederdi.
    expect($katalog->topla(array_fill(0, 5, sartFaaliyet('TR Dizin')), $tumu))->toBe(60);

    // 11. bölümün iki katmanlı tavanı: 11.3 (WoS atfı) 500'e kadar, öteki
    // atıflar TOPLAMDA 100'de kesiliyor.
    $wos = array_fill(0, 300, sartFaaliyet('WoS / Scopus', Kategori::Atif));
    $ulusal = array_fill(0, 200, sartFaaliyet('TR Dizin', Kategori::Atif));
    expect($katalog->topla($wos, $tumu))->toBe(500)
        ->and($katalog->topla($ulusal, $tumu))->toBe(100);

    // 9. bölüm (editörlük) 300: on baş editörlük (40) tavansız 400 ederdi.
    expect($katalog->topla(array_fill(0, 10, sartFaaliyet('WoS Dergi (Q1)', Kategori::Editorluk)), $tumu))
        ->toBe(300);
});

test('Ağrı atıf tavanı alt barajı sahte sağlamayı kesiyor', function () {
    $depo = sartDepo();
    $katalog = $depo->katalog('agri-2024');

    // 7.1 atıf başına 6 puan. "1, 4 ve 7 numaralı maddelerden en az 100 puan"
    // barajı tavansızken yirmi atıfla (120) tek başına sağlanıyordu.
    $atiflar = array_fill(0, 20, sartFaaliyet('WoS / Scopus', Kategori::Atif));
    expect($katalog->topla($atiflar, $katalog->coz(['1', '4.1', '4.2', '4.3', '7.1'])))->toBe(30);
});

test('Amasya tez jürisi ve ders tavanları uygulanıyor', function () {
    $katalog = (new SartDeposu)->katalog('amasya-2024');
    $tumu = $katalog->coz(['*']);

    // "Tez Jüri Üyeliği (… en fazla 20 puan)": on jüri üyeliği (4) 40 ederdi.
    expect($katalog->topla(array_fill(0, 10, sartFaaliyet('Tez İzleme / Jüri Üyeliği', Kategori::TezDanismanligi)), $tumu))
        ->toBe(20);

    // "Dersler … en fazla 40 puan": kırk ders tavansız çok daha fazla ederdi.
    expect($katalog->topla(array_fill(0, 40, sartFaaliyet('Lisansüstü Ders', Kategori::EgitimOgretim)), $tumu))
        ->toBe(40);
});

test('KTÜN O bölümü ve ders tavanları iki varyantta da uygulanıyor', function () {
    $depo = sartDepo();

    foreach (['ktun-2024', 'ktun-2024-mps'] as $anahtar) {
        $katalog = $depo->katalog($anahtar);
        $tumu = $katalog->coz(['*']);

        // "O bölümünün tamamından en fazla 100 puan kullanılabilir":
        // yüz hakemlik (2) tavansız 200 ederdi.
        expect($katalog->topla(array_fill(0, 100, sartFaaliyet('Hakemlik', Kategori::Editorluk)), $tumu))
            ->toBe(100);

        // H-1 dipnotu: "bu faaliyet kapsamında aday en fazla 20 puan alabilir."
        expect($katalog->topla(array_fill(0, 40, sartFaaliyet('Lisansüstü Ders', Kategori::EgitimOgretim)), $tumu))
            ->toBe(20);
    }
});

test('MSGSÜ adet tavanları puana çevrilip uygulanıyor', function () {
    $katalog = (new SartDeposu)->katalog('msgsu-2023');
    $tumu = $katalog->coz(['*']);

    // "Hakemlik (en çok beş adet)" × 3 puan = 15; yirmi hakemlik 60 ederdi.
    expect($katalog->topla(array_fill(0, 20, sartFaaliyet('Hakemlik', Kategori::Editorluk)), $tumu))->toBe(15);

    // "Kitap çevirisi (en çok bir adet)" × 15 = 15; üç çeviri 45 ederdi.
    expect($katalog->topla(array_fill(0, 3, sartFaaliyet('Çeviri Kitap', Kategori::Kitap)), $tumu))->toBe(15);

    // Tavan 1. kısmın 200 puanlık barajını sağlanamaz yapmıyor: bölümün
    // tavansız satırları (makale, kitap) barajı tek başına taşıyabiliyor.
    $makaleler = array_fill(0, 10, sartFaaliyet('SCIE/SSCI (Q1)'));
    expect($katalog->topla($makaleler, $katalog->coz(['1'])))->toBeGreaterThanOrEqual(200);
});

test('Afyon atıf tavanı ve Bandırma diğer atıf tavanı uygulanıyor', function () {
    $depo = sartDepo();

    // Afyon: "Atıflardan en fazla 500 puan alınabilir." SCI atfı 7 puan.
    $afyon = $depo->katalog('afyon-2026');
    expect($afyon->topla(array_fill(0, 200, sartFaaliyet('WoS / Scopus', Kategori::Atif)), $afyon->coz(['*'])))
        ->toBe(500);

    // Bandırma: "B11.b) Diğer atıflar (En fazla 20 puan dikkate alınır.)"
    // Atıf başına 1 puan; TR Dizin atfı (B11.a, 2 puan) tavanın dışında.
    $bandirma = $depo->katalog('bandirma-2024');
    $tumu = $bandirma->coz(['*']);
    expect($bandirma->topla(array_fill(0, 100, sartFaaliyet('Diğer', Kategori::Atif)), $tumu))->toBe(20)
        ->and($bandirma->topla(array_fill(0, 100, sartFaaliyet('TR Dizin', Kategori::Atif)), $tumu))->toBe(200);
});

test('ADÜ ders verme ve jüri üyeliği tavanları uygulanıyor', function () {
    $katalog = (new SartDeposu)->katalog('adu-2024');
    $tumu = $katalog->coz(['*']);

    // "C2 Ders Verme — En fazla 100 puan alınabilir." Koordinatörlük 5 puan.
    expect($katalog->topla(array_fill(0, 40, sartFaaliyet('Anabilim Dalı Başkanı / Koordinatörlük', Kategori::IdariGorev)), $tumu))
        ->toBe(100);

    // "D5 Jüri ve Komisyon Üyelikleri — En fazla 100 puan alınabilir."
    // Jüri üyeliği 15 puan; yirmi üyelik tavansız 300 ederdi.
    expect($katalog->topla(array_fill(0, 20, sartFaaliyet('Jüri Üyeliği (Uluslararası)', Kategori::SanatselEtkinlik)), $tumu))
        ->toBe(100);
});

test('Ege editörlük tavanı bütün çeyrekliklere uygulanıyor', function () {
    $katalog = (new SartDeposu)->katalog('ege-2026');
    $tumu = $katalog->coz(['*']);

    // "Bu kategoride en çok 75 puan alınır." Tavan tek maddeye ('7a-Q1')
    // bağlıydı; Q2 editörlüğü (10 puan) sınırsız sayılıyordu.
    expect($katalog->topla(array_fill(0, 10, sartFaaliyet('WoS Dergi (Q2)', Kategori::Editorluk)), $tumu))->toBe(75)
        ->and($katalog->topla(array_fill(0, 10, sartFaaliyet('WoS Dergi (Q4)', Kategori::Editorluk)), $tumu))->toBe(50)
        ->and($katalog->topla(array_fill(0, 10, sartFaaliyet('WoS Dergi (Q1)', Kategori::Editorluk)), $tumu))->toBe(75);
});

test('Gaziantep atıf, proje ve editörlük tavanları uygulanıyor', function () {
    $katalog = (new SartDeposu)->katalog('gaziantep-2026');
    $tumu = $katalog->coz(['*']);

    // "Not 1: Atıflardan en fazla 200 puan hesaplamada kullanılabilir."
    expect($katalog->topla(array_fill(0, 300, sartFaaliyet('WoS / Scopus', Kategori::Atif)), $tumu))->toBe(200);

    // "j) BAP (en fazla 50 puan alınabilir)" — yürütücülük 10 puan.
    expect($katalog->topla(array_fill(0, 10, sartFaaliyet('BAP (Üniversite)', Kategori::Proje, 'yurutucu')), $tumu))
        ->toBe(50);

    // Editörlük iki katmanlı: 6b'nin kendi tavanı 100, bölümün tamamı 150.
    $digerKitap = array_fill(0, 10, sartFaaliyet('Kitap Editörlüğü', Kategori::Editorluk));
    expect($katalog->topla($digerKitap, $tumu))->toBe(100);

    $bkci = array_fill(0, 10, sartFaaliyet('BKCI Kitap', Kategori::Editorluk));
    expect($katalog->topla($bkci, $tumu))->toBe(150);

    // Hakemlik ayrı bir bölüm; 150'nin dışında ve kendi tavanı 20.
    expect($katalog->topla(array_fill(0, 40, sartFaaliyet('Hakemlik', Kategori::Editorluk)), $tumu))->toBe(20);
});

test('Ardahan satır düzeyindeki azami puanlar uygulanıyor', function () {
    $katalog = (new SartDeposu)->katalog('ardahan-2026');
    $tumu = $katalog->coz(['*']);

    // "4.1.14 Ulusal Faydalı Model tescili * Azami 45 puan alınabilir." (15 puan)
    expect($katalog->topla(array_fill(0, 10, sartFaaliyet('Faydalı Model', Kategori::Patent)), $tumu))->toBe(45);

    // "3.11.6 … Davetli Konuşmacı * Azami 10 puan alınabilir." (5 puan)
    expect($katalog->topla(array_fill(0, 10, sartFaaliyet('Davetli Konuşmacı', Kategori::Bildiri)), $tumu))->toBe(10);

    // "4.9.5 … medyada katılımcı * Azami 3 puan alınabilir." (1 puan)
    expect($katalog->topla(array_fill(0, 10, sartFaaliyet('Bilim İletişimi / Popüler Yayın', Kategori::ToplumsalKatki)), $tumu))
        ->toBe(3);
});

test('Eskişehir Teknik 1f tavanı kadroya göre uygulanıyor', function () {
    $depo = sartDepo();

    // EK-5: Tablo 1'de 75, Tablo 2'de 45, Tablo 3-4'te 150.
    $tavan = fn (string $anahtar): array => $depo->cetveller()[$anahtar]->grupTavanlari;
    expect($tavan('eskisehir-teknik-2026-1f75')['1f'])->toBe(75)
        ->and($tavan('eskisehir-teknik-2026-1f45')['1f'])->toBe(45)
        ->and($tavan('eskisehir-teknik-2026-1f150')['1f'])->toBe(150)
        ->and($tavan('eskisehir-teknik-2026'))->not->toHaveKey('1f');

    // Eşikler doğru varyanta bağlı; mühendislik tavansız gövdede kalıyor.
    expect($depo->bul('Eskişehir Teknik Üniversitesi', 'dr_ogr_uyesi_yeniden', 'sosyal')['cetvel'])
        ->toBe('eskisehir-teknik-2026-1f45')
        ->and($depo->bul('Eskişehir Teknik Üniversitesi', 'profesorluk', 'sosyal')['cetvel'])
        ->toBe('eskisehir-teknik-2026-1f150')
        ->and($depo->bul('Eskişehir Teknik Üniversitesi', 'profesorluk', 'muhendislik')['cetvel'])
        ->toBe('eskisehir-teknik-2026');

    // TR Dizin makalesi 75 puan; yeniden atanmada makale barajına en fazla
    // 45 puan girebiliyor, tavansızken beş makale 375 puan sayılıyordu.
    $katalog = $depo->katalog('eskisehir-teknik-2026-1f45');
    expect($katalog->topla(array_fill(0, 5, sartFaaliyet('TR Dizin')), $katalog->coz(['1a-f'])))->toBe(45);
});

test('Kahramanmaraş İstiklal ansiklopedi adet tavanı puana çevrilip uygulanıyor', function () {
    $katalog = (new SartDeposu)->katalog('kahramanmaras-istiklal-2024');
    $tumu = $katalog->coz(['*']);

    // "En fazla altı maddeden puan alınabilir" × 10 puan = 60.
    expect($katalog->topla(array_fill(0, 20, sartFaaliyet('Ansiklopedi Maddesi', Kategori::Kitap)), $tumu))
        ->toBe(60);
});

test('AYBÜ alanlara özgü satır tavanları bölüm tavanının altında uygulanıyor', function () {
    $depo = sartDepo();
    $katalog = $depo->katalog('aybu-2026');
    $tumu = $katalog->coz(['*']);

    // "g) … podcast yayınlarına katılmak (En fazla 10 puan alınabilir)" — 4 puan.
    // Bölüm tavanı 30, yani satır tavanı olmadan beş katılım 20 puan sayardı.
    expect($katalog->topla(array_fill(0, 5, sartFaaliyet('Bilim İletişimi / Popüler Yayın', Kategori::ToplumsalKatki)), $tumu))
        ->toBe(10);

    // Sanat varyantında bölüm tavanı 60'a çıkıyor ama satır tavanı aynı kalıyor.
    $sanat = $depo->katalog('aybu-2026-sanat');
    expect($sanat->grupTavanlari['ALANLARA-OZGU'])->toBe(60)
        ->and($sanat->grupTavanlari['AO.g'])->toBe(10);
});

test('Yalova poster bildirisi "poster hariç" satırlarından sayılmıyor', function () {
    $depo = sartDepo();
    $katalog = $depo->katalog('yalova-2024-sosyal-a150');
    $tumu = $katalog->coz(['*']);

    // 8a ve 8b'nin başlığı "(poster hariç)" diyor; etiket bu satırlardan
    // çıkarıldı. Tam metin bildiri sayılmaya devam ediyor.
    expect($katalog->topla([sartFaaliyet('Uluslararası Tam Metin (CPCI)', Kategori::Bildiri)], $tumu))->toBe(5)
        ->and($katalog->topla([sartFaaliyet('Uluslararası Özet/Poster', Kategori::Bildiri)], $tumu))->toBe(0)
        ->and($katalog->topla([sartFaaliyet('Ulusal Özet/Poster', Kategori::Bildiri)], $tumu))->toBe(0);

    // Asıl kazanç SAYIDA: "8 kapsamında en az N bildiri" koşulu adet sayıyor
    // ve orada puanın küçüklüğü hiçbir şeyi korumuyor.
    expect($katalog->coz(['8']))->not->toBeEmpty();
});

test('akreditasyon faaliyeti ders sayılmıyor, kendi satırından puanlanıyor', function () {
    $depo = sartDepo();
    $akreditasyon = sartFaaliyet('Akreditasyon Faaliyeti', Kategori::EgitimOgretim);
    $ders = sartFaaliyet('Lisans/Önlisans Ders', Kategori::EgitimOgretim);

    // Kaynağı akreditasyonu puanlayan üç cetvelde kendi satırından geliyor.
    foreach (['omu-2025' => 6, 'yozgat-bozok-2025' => 3, 'isik-2019' => 3] as $anahtar => $puan) {
        $katalog = $depo->katalog($anahtar);
        expect($katalog->puan($akreditasyon, $katalog->coz(['*'])))->toBe($puan);
    }

    // Kaynağı akreditasyonu HİÇ ANMAYAN cetvellerde artık sıfır; önceden
    // ders satırından puan alıyor ve ders SAYISI koşullarını besliyordu.
    foreach (['mef-2024-muhendislik-docent', 'gaziantep-2026', 'anadolu-2023'] as $anahtar) {
        $katalog = $depo->katalog($anahtar);
        expect($katalog->puan($akreditasyon, $katalog->coz(['*'])))->toBe(0)
            ->and($katalog->puan($ders, $katalog->coz(['*'])))->toBeGreaterThan(0);
    }
});

test('OMÜ 14. bölüm idari görev ve toplumsal katkı satırları çalışıyor', function () {
    $depo = sartDepo();
    $katalog = $depo->katalog('omu-2025');
    $tumu = $katalog->coz(['*']);
    $p = fn (string $kaynak, Kategori $k) => $katalog->puan(sartFaaliyet($kaynak, $k), $tumu);

    // 14.1-14.3, 14.5: kaynağın kademeleri.
    expect($p('Dekan / Enstitü-YO Müdürü', Kategori::IdariGorev))->toBe(30)
        ->and($p('Bölüm Başkanı', Kategori::IdariGorev))->toBe(20)
        ->and($p('Kurul / Komisyon Üyeliği', Kategori::IdariGorev))->toBe(5)
        ->and($p('Uygulama ve Araştırma Merkezi Müdürü', Kategori::IdariGorev))->toBe(3);

    // 14.7 ve 14.16: bölümden önce OMÜ'de hiç toplumsal katkı satırı yoktu.
    expect($p('Topluma Hizmet Projesi', Kategori::ToplumsalKatki))->toBe(6)
        ->and($p('Kamu/STK Danışmanlığı', Kategori::ToplumsalKatki))->toBe(4);

    // Kaynak rektörlüğü 14. bölümde saymıyor; satırı da yok.
    expect($p('Rektör', Kategori::IdariGorev))->toBe(0);

    // Tez izleme komitesi üyeliği kaynağın 10. bölümünde YOK, 14.5'in
    // örneklerinde var (6/3 → §0 düşük). Bir tur 10.2'de 20 puandaydı.
    expect($p('Tez İzleme / Jüri Üyeliği', Kategori::TezDanismanligi))->toBe(3);

    // '1-14' ve '1-15' artık 14. bölümü sayıyor ve birbirinden farklı.
    expect($katalog->coz(['1-14']))->toContain('14.1')
        ->and(count($katalog->coz(['1-15'])))->toBeGreaterThan(count($katalog->coz(['1-10'])));
});

test('OMÜ 15. bölüm görsel etkinlikleri en düşük bentten sayıyor', function () {
    $depo = sartDepo();
    $katalog = $depo->katalog('omu-2025');
    $tumu = $katalog->coz(['*']);
    $p = fn (string $kaynak) => $katalog->puan(sartFaaliyet($kaynak, Kategori::SanatselEtkinlik), $tumu);

    // Kaynak yönetmenliği (80/40) öteki görevlerden (36/18) ayırıyor; etiket
    // rolü taşımadığı için §0 uyarınca DÜŞÜK bent yazıldı.
    expect($p('Uzun Metrajlı Film / Belgesel (Uluslararası)'))->toBe(20)
        ->and($p('Uzun Metrajlı Film / Belgesel (Ulusal)'))->toBe(10)
        ->and($p('Belgesel/Kısa Film (Uluslararası)'))->toBe(20)
        ->and($p('TV Programı (Uluslararası)'))->toBe(8)
        ->and($p('TV Programı (Ulusal)'))->toBe(6);

    // Girilmeyen etiketler puan üretmiyor: reklam (kaynak yalnız yönetmenliği
    // sayıyor), sahne yönetmenliği ve animasyon.
    expect($p('Reklam / Tanıtım Filmi (Uluslararası)'))->toBe(0)
        ->and($p('Yönetmenlik (Sahne/Ekran)'))->toBe(0)
        ->and($p('Animasyon / Canlandırma Yapımı'))->toBe(0);

    // 15. bölüm yalnız B ve C gruplarının aralığında; A grubu ('1-14') dışında.
    expect($katalog->coz(['1-15']))->toContain('15.2-15.4')
        ->and($katalog->coz(['1-14']))->not->toContain('15.2-15.4');

    // Aralıklar artık kesin artıyor.
    $n = fn (string $g) => count($katalog->coz([$g]));
    expect($n('1-10'))->toBeLessThan($n('1-14'))
        ->and($n('1-14'))->toBeLessThan($n('1-15'))
        ->and($n('1-15'))->toBeLessThan($n('1-16'));
});

test('OMÜ 16. bölüm sanatsal etkinlikleri üç eksende ayırıyor', function () {
    $depo = sartDepo();
    $katalog = $depo->katalog('omu-2025');
    $tumu = $katalog->coz(['*']);
    $p = fn (string $kaynak) => $katalog->puan(sartFaaliyet($kaynak, Kategori::SanatselEtkinlik), $tumu);

    // Yer × jüri × katılım biçimi: kaynağın on yedi bendinin kademeleri.
    expect($p('Kişisel Etkinlik (Uluslararası)'))->toBe(60)          // 16.3 yurt dışı, uluslararası jürili
        ->and($p('Kişisel Etkinlik (Yurt Dışı, Ulusal Jürili)'))->toBe(35)   // 16.5
        ->and($p('Kişisel Etkinlik (Yurt Dışı, Jürisiz)'))->toBe(20)         // 16.7
        ->and($p('Kişisel Etkinlik (Yurt İçi, Uluslararası Jürili)'))->toBe(15) // 16.10
        ->and($p('Kişisel Etkinlik (Ulusal)'))->toBe(20)                     // 16.12
        ->and($p('Kişisel Etkinlik (Yurt İçi, Jürisiz)'))->toBe(15);         // 16.14

    expect($p('Karma/Jürili Etkinlik (Uluslararası)'))->toBe(30)     // 16.4
        ->and($p('Karma Etkinlik (Yurt Dışı, Ulusal Jürili)'))->toBe(30)     // 16.6
        ->and($p('Karma Etkinlik (Yurt Dışı, Jürisiz)'))->toBe(10)           // 16.8
        ->and($p('Karma Etkinlik (Yurt İçi, Uluslararası Jürili)'))->toBe(10) // 16.11
        ->and($p('Karma/Jürili Etkinlik (Ulusal)'))->toBe(5)                 // 16.13
        ->and($p('Karma Etkinlik (Jürisiz, Ulusal)'))->toBe(10);             // 16.15

    // 16.17 bölümün en yüksek bendi; müze kabulü yurt içi ve dışı aynı puan.
    expect($p('Eserin Müzeye Kabulü (Yurt Dışı)'))->toBe(100)
        ->and($p('Eserin Müzeye Kabulü (Yurt İçi)'))->toBe(100);

    // Önceki eşleme ulusal kalemleri fazla sayıyordu: kişisel 40 (doğrusu
    // 20), ulusal karma 20 (doğrusu 5).
    expect($p('Kişisel Etkinlik (Ulusal)'))->toBeLessThan(40)
        ->and($p('Karma/Jürili Etkinlik (Ulusal)'))->toBeLessThan(20);

    // Bendi okunamayan etiketler puan üretmiyor.
    expect($p('Elektronik Kişisel Sergi (Uluslararası)'))->toBe(0)
        ->and($p('Grup Şefliği (Uluslararası)'))->toBe(0)
        ->and($p('Sahne, TV, Radyo, Sinema Yapıtı (Uluslararası)'))->toBe(0);
});

test('OMÜ 13. bölüm ödülleri verene ve dereceye göre ayırıyor', function () {
    $depo = sartDepo();
    $katalog = $depo->katalog('omu-2025');
    $tumu = $katalog->coz(['*']);
    $p = fn (string $kaynak, Kategori $k = Kategori::Odul) => $katalog->puan(sartFaaliyet($kaynak, $k), $tumu);

    // Kaynağın kademeleri: 13.3-13.4 (80), 13.7 (50), 13.8 (30),
    // yarışma derecesi en düşük 15, burs 40/25.
    expect($p('TÜBİTAK / TÜBA Ödülü'))->toBe(80)
        ->and($p('YÖK Ödülü'))->toBe(80)
        ->and($p('Uluslararası Bilim/Sanat Ödülü'))->toBe(50)
        ->and($p('TÜBA GEBİP / TWAS Teşvik Ödülü'))->toBe(50)
        ->and($p('Ulusal Bilim/Sanat Ödülü'))->toBe(30)
        ->and($p('Ufuk Avrupa / ERC Ödülü'))->toBe(40)
        ->and($p('Burs'))->toBe(25)
        ->and($p('Yarışma Derecesi / Mansiyon'))->toBe(15);

    // Ödül dışı hizmet kalemleri.
    expect($p('Festival Koordinatörlüğü (Uluslararası)', Kategori::SanatselEtkinlik))->toBe(20)
        ->and($p('Festival Koordinatörlüğü (Ulusal)', Kategori::SanatselEtkinlik))->toBe(10)
        ->and($p('Davetli Konuşmacı', Kategori::Bildiri))->toBe(10)
        ->and($p('Öğrenci Projesi (2209 vb.)', Kategori::Proje))->toBe(8);

    // Önceki eşlemenin fazla saydığı üç kalem artık kaynağın değerinde.
    // (Davetli konuşmacı 20 → 10, öğrenci projesi 20 → 8, yarışma 30 → 15.)
    expect($p('Davetli Konuşmacı', Kategori::Bildiri))->toBeLessThan(20)
        ->and($p('Öğrenci Projesi (2209 vb.)', Kategori::Proje))->toBeLessThan(20)
        ->and($p('Yarışma Derecesi / Mansiyon'))->toBeLessThan(30);

    // Etiketi zaten 14. bölümde minimumda olanlara ayrı satır açılmadı.
    expect($p('Kurul / Komisyon Üyeliği', Kategori::IdariGorev))->toBe(5)
        ->and($p('Kamu/STK Danışmanlığı', Kategori::ToplumsalKatki))->toBe(4);
});

test('OMÜ 1-12. bölümleri kaynağın kademeleriyle puanlıyor', function () {
    $depo = sartDepo();
    $katalog = $depo->katalog('omu-2025-a-doc');
    $tumu = $katalog->coz(['*']);
    $p = fn (string $kaynak, Kategori $k, ?string $rol = 'tek') => $katalog->puan(sartFaaliyet($kaynak, $k, $rol), $tumu);

    // 1.3 editörlük çeyrekliğe göre kademeli (70/60/50/40); tek satırda
    // 40'ta toplanmıştı, etiketler çeyrekliği taşıyor.
    expect($p('WoS Dergi (Q1)', Kategori::Editorluk))->toBe(70)
        ->and($p('WoS Dergi (Q4)', Kategori::Editorluk))->toBe(40);

    // Hakemlik ve yayın kurulu üyeliği derginin indeksini taşımıyor;
    // kaynak dört bölümde ayrı puanlıyor → en düşüğü (2 ve 6).
    // Hakemlik 15, yayın kurulu 21 puandaydı.
    expect($p('Hakemlik', Kategori::Editorluk))->toBe(2)
        ->and($p('Yayın Kurulu Üyeliği', Kategori::Editorluk))->toBe(6);

    // Bildiri: kaynağın ekseni indeks, kayıt indeksi taşımıyor → 5.5/5.6.
    // Özet/poster 20 ve 10 puandaydı; kaynakta 3 ve 2.
    expect($p('Uluslararası Özet/Poster', Kategori::Bildiri))->toBe(3)
        ->and($p('Ulusal Özet/Poster', Kategori::Bildiri))->toBe(2)
        ->and($p('Uluslararası Tam Metin (CPCI)', Kategori::Bildiri))->toBe(10);

    // Tez danışmanlığı kaynakta 20/10; cetvelde 40/20 idi.
    expect($p('Doktora Tezi', Kategori::TezDanismanligi))->toBe(20)
        ->and($p('Yüksek Lisans Tezi', Kategori::TezDanismanligi))->toBe(10);

    // Proje: fon kademesi × rol matrisi.
    expect($p('AB Çerçeve / Ufuk', Kategori::Proje, 'yurutucu'))->toBe(120)
        ->and($p('TÜBİTAK', Kategori::Proje, 'yurutucu'))->toBe(90)
        ->and($p('TÜBİTAK', Kategori::Proje, 'arastirmaci'))->toBe(35)
        ->and($p('BAP (Üniversite)', Kategori::Proje, 'yurutucu'))->toBe(40);

    // Patent tescil değerleri 150/75 (100/60 idi).
    expect($p('Uluslararası Patent', Kategori::Patent))->toBe(150)
        ->and($p('Ulusal Patent', Kategori::Patent))->toBe(75);
});

test('OMÜ yüzde tavanları alan grubu ve kadroya göre uygulanıyor', function () {
    $depo = sartDepo();
    $tavan = fn (string $anahtar): array => $depo->cetveller()[$anahtar]->grupTavanlari;

    // 5. bölüm A ve B'de %20, C'de %45; taban 1-10 asgari puanı.
    expect($tavan('omu-2025-a-doc')['5'])->toBe(72)      // 360 × %20
        ->and($tavan('omu-2025-b-doc')['5'])->toBe(66)   // 330 × %20
        ->and($tavan('omu-2025-c-doc')['5'])->toBe(67);  // 150 × %45 = 67,5 → 67

    // 7. bölüm A %20, B %30, C %60.
    expect($tavan('omu-2025-a-prof')['7'])->toBe(144)    // 720 × %20
        ->and($tavan('omu-2025-b-prof')['7'])->toBe(198) // 660 × %30
        ->and($tavan('omu-2025-c-prof')['7'])->toBe(180); // 300 × %60

    // Her eşik kendi varyantına bağlı.
    expect($depo->bul('Ondokuz Mayıs Üniversitesi', 'dr_ogr_uyesi', 'fen')['cetvel'])->toBe('omu-2025-a-dr')
        ->and($depo->bul('Ondokuz Mayıs Üniversitesi', 'profesorluk', 'guzel_sanatlar')['cetvel'])->toBe('omu-2025-c-prof');

    // Tavan gerçekten kesiyor: yirmi uluslararası tam metin bildiri (10)
    // tavansız 200 ederdi, C doçentlikte 67'de kesiliyor.
    $katalog = $depo->katalog('omu-2025-c-doc');
    expect($katalog->topla(array_fill(0, 20, sartFaaliyet('Uluslararası Tam Metin (CPCI)', Kategori::Bildiri)), $katalog->coz(['*'])))
        ->toBe(67);
});

test('Adıyaman ve Manisa CBÜ yüzde tavanları kadroya göre uygulanıyor', function () {
    $depo = sartDepo();
    $tavan = fn (string $anahtar): array => $depo->cetveller()[$anahtar]->grupTavanlari;

    // Adıyaman: B %15, D ve F %20; taban Tablo 3'ün asgari toplamı
    // (fen Dr. 400 / profesör 900, sosyal 300 / 700).
    expect($tavan('adiyaman-2024-fen-dr')['B'])->toBe(60)
        ->and($tavan('adiyaman-2024-fen-prof')['D'])->toBe(180)
        ->and($tavan('adiyaman-2024-sosyal-prof')['B'])->toBe(105)
        // Doçentlikte toplam puan barajı yok, taban da yok → tavansız.
        ->and($tavan('adiyaman-2024'))->toBe([]);

    expect($depo->bul('Adıyaman Üniversitesi', 'dr_ogr_uyesi', 'fen')['cetvel'])->toBe('adiyaman-2024-fen-dr')
        ->and($depo->bul('Adıyaman Üniversitesi', 'docentlik', 'fen')['cetvel'])->toBe('adiyaman-2024');

    // Adıyaman bildiri satırları kaynağın uluslararası/ulusal blokuna göre
    // yeniden kuruldu; ulusal bildiri tek satırda 20 puandaydı, kaynakta
    // tam metin 30, özet 15 → §0 uyarınca özet 15.
    $katalog = $depo->katalog('adiyaman-2024-fen-dr');
    $tumu = $katalog->coz(['*']);
    expect($katalog->puan(sartFaaliyet('Ulusal Özet/Poster', Kategori::Bildiri), $tumu))->toBe(15)
        ->and($katalog->puan(sartFaaliyet('Uluslararası Özet/Poster', Kategori::Bildiri), $tumu))->toBe(30);

    // Manisa CBÜ: atıf tavanı kadronun toplam puanının %20'si.
    expect($tavan('manisa-cbu-2024-docent')['ATIF'])->toBe(120)      // 600 × %20
        ->and($tavan('manisa-cbu-2024-profesor')['ATIF'])->toBe(240) // 1200 × %20
        ->and($tavan('manisa-cbu-2024'))->toBe([]);

    // Tavan gerçekten kesiyor: elli WoS atfı doçentlikte 120'de duruyor.
    $mcbu = $depo->katalog('manisa-cbu-2024-docent');
    expect($mcbu->topla(array_fill(0, 50, sartFaaliyet('WoS / Scopus', Kategori::Atif)), $mcbu->coz(['*'])))
        ->toBe(120);
});

test('Çukurova ve Abdullah Gül başlık denetiminin bulduğu satırlar', function () {
    $depo = sartDepo();

    // ── ÇUKUROVA: üç kalem hiç sayılmıyordu ──
    $cu = $depo->katalog('cukurova-2024');
    $ct = $cu->coz(['*']);
    expect($cu->puan(sartFaaliyet('Ticarileştirme', Kategori::Patent), $ct))->toBe(60)
        ->and($cu->puan(sartFaaliyet('Yarışma Derecesi / Mansiyon', Kategori::Odul), $ct))->toBe(45)
        ->and($cu->puan(sartFaaliyet('Jüri Üyeliği (Ulusal)', Kategori::SanatselEtkinlik), $ct))->toBe(90);

    // Girilen satırlar kaynağın değerinde kalmalı (denetim fazla sayma bulmadı).
    expect($cu->puan(sartFaaliyet('SCIE/SSCI (Q1)'), $ct))->toBe(90)
        ->and($cu->puan(sartFaaliyet('BKCI / Scopus Kitap', Kategori::Kitap), $ct))->toBe(60);

    // ── ABDULLAH GÜL ──
    $agu = $depo->katalog('abdullah-gul-2026');
    $at = $agu->coz(['*']);

    // TR Dizin makalesinin satırı yoktu, sıfır alıyordu.
    expect($agu->puan(sartFaaliyet('TR Dizin'), $at))->toBe(6);

    // "B grubu projeler: A Grubu / 2" — etiket A/B ayrımını taşımıyor,
    // §0 uyarınca düşük kademe. Yürütücü 20 → 10, araştırmacı 10 → 5.
    expect($agu->puan(sartFaaliyet('TÜBİTAK', Kategori::Proje, 'yurutucu'), $at))->toBe(10)
        ->and($agu->puan(sartFaaliyet('TÜBİTAK', Kategori::Proje, 'arastirmaci'), $at))->toBe(5);

    // Çok ortaklı yöneticilik (50) ile düz yürütücülük (30) ayrılamıyor.
    expect($agu->puan(sartFaaliyet('AB Çerçeve / Ufuk', Kategori::Proje, 'yurutucu'), $at))->toBe(30);

    // Kitapta "ulusal = uluslararası / 2,5" kademesi zaten doğruydu.
    expect($agu->puan(sartFaaliyet('BKCI / Scopus Kitap', Kategori::Kitap), $at))->toBe(40)
        ->and($agu->puan(sartFaaliyet('Uluslararası/Ulusal Kitap', Kategori::Kitap), $at))->toBe(10);
});

test('YÖK 30.01.2025 jürili yarışma maddeleri beş cetvelde de sayılıyor', function () {
    $depo = sartDepo();
    $yarisma = sartFaaliyet('Yarışma Derecesi / Mansiyon', Kategori::Odul);
    $juri = sartFaaliyet('Jüri Üyeliği (Ulusal)', Kategori::SanatselEtkinlik);

    // Kaynağın verdiği değerler; hepsi bu turdan önce SIFIR alıyordu.
    $beklenen = [
        'cukurova-2024' => [45, 90],
        'giresun-2019' => [7, 15],     // M.18 7,5 → §0 aşağı yuvarlandı
        'kocaeli-2023' => [null, 25],  // yarışma ödülleri J bölümünde, girilmedi
        'acibadem-2025-atif18' => [10, 10],
        'piri-reis-2025-fen' => [2, 2],
    ];

    foreach ($beklenen as $anahtar => [$y, $j]) {
        $katalog = $depo->katalog($anahtar);
        $tumu = $katalog->coz(['*']);

        if ($y !== null) {
            expect($katalog->puan($yarisma, $tumu))->toBe($y);
        }

        expect($katalog->puan($juri, $tumu))->toBe($j);
    }

    // Kocaeli'nin H.1-H.22 kümesi önek deseniyle H23-H29'u da yakalıyordu;
    // açık listeye çevrildi ve yeni satır kümenin dışında kaldı.
    $kocaeli = $depo->katalog('kocaeli-2023');
    expect($kocaeli->coz(['H.1-H.22']))->not->toContain('H29')
        ->and($kocaeli->coz(['H.1-H.22']))->not->toContain('H28');
});

test('YÖK 27.11.2025 değişikliği: SBÜ idari görev bölümü Dr. kadrosunda sayılmıyor', function () {
    $depo = sartDepo();
    $rektor = sartFaaliyet('Rektör', Kategori::IdariGorev);

    // Kaynağın D başlığı "(Yalnızca Profesör ve Doçent kadroları için)" diyor.
    $doc = $depo->katalog('sbu-2025');
    $dr = $depo->katalog('sbu-2025-dr');

    expect($doc->grupTavanlari['D'])->toBe(50)
        ->and($dr->grupTavanlari['D'])->toBe(0)
        ->and($doc->puan($rektor, $doc->coz(['*'])))->toBe(50)
        // Tavan 0 hem doğrudan eşleşmeyi hem karşılık aramasını kesiyor.
        ->and($dr->topla([$rektor], $dr->coz(['*'])))->toBe(0);

    // Her kadro kendi varyantına bağlı.
    expect($depo->bul('Sağlık Bilimleri Üniversitesi', 'dr_ogr_uyesi', 'saglik')['cetvel'])->toBe('sbu-2025-dr')
        ->and($depo->bul('Sağlık Bilimleri Üniversitesi', 'profesorluk', 'saglik')['cetvel'])->toBe('sbu-2025');

    // Fırat'ın C6'sı kaynakta duruyor ama tablodan çıkarılmış; satırı yok.
    $firat = $depo->katalog('firat-2026');
    expect(array_keys($firat->maddeler))->not->toContain('C6');
});

test('Bayburt yabancı dil koşulu altı eşikte de sorulıyor', function () {
    $depo = sartDepo();
    $sayac = 0;

    foreach ($depo->esikler() as $esik) {
        if (($esik['universite'] ?? '') !== 'Bayburt Üniversitesi') {
            continue;
        }

        $sayac++;
        $bulundu = false;
        $gez = function (array $d) use (&$gez, &$bulundu): void {
            if (($d['metrik'] ?? null) === 'yds') {
                $bulundu = true;
            }
            foreach ($d['cocuklar'] ?? [] as $c) {
                $gez($c);
            }
        };
        $gez($esik['sart']);

        expect($bulundu)->toBeTrue("{$esik['anahtar']} eşiğinde yabancı dil koşulu yok");
    }

    expect($sayac)->toBeGreaterThanOrEqual(6);
});

/**
 * AKDENİZ 11. BÖLÜM: DİSİPLİNE ÖZGÜ ETKİNLİK VE FAALİYETLER.
 *
 * Kaynak bölümü altı FAKÜLTE tablosuna bölüyor ve "her temel bilim alanı
 * kendi özel alanından puan alır" diyor. Aynı sözlük etiketi tablodan
 * tabloya farklı puan aldığı için cetvel disipline göre varyantlandı; tek
 * cetvele toplansaydı `puan()` en yükseği aldığı için herkes en cömert
 * tabloyu alırdı.
 */
test('Akdeniz 11. bölüm satırları yalnız kendi disiplininin cetvelinde', function () {
    $depo = sartDepo();
    $derece = sartFaaliyet('Yarışma Derecesi / Mansiyon', Kategori::Odul, null);

    $puan = function (string $cetvel) use ($depo, $derece): int {
        $katalog = $depo->katalog($cetvel);

        return $katalog === null ? -1 : $katalog->puan($derece, $katalog->coz(['*']));
    };

    // 11.1.10 Türkiye şampiyonası ilk üç 20 · 11.2.11 mimarlık yarışması 50
    // 11.6.3 Kur'an-ı Kerim yarışması (ulusal) 50
    expect($puan('akdeniz-2026-spor-dr'))->toBe(20)
        ->and($puan('akdeniz-2026-mimarlik-dr'))->toBe(50)
        ->and($puan('akdeniz-2026-ilahiyat-dr'))->toBe(50)
        // Temel cetvelde (fen, mühendislik, sağlık, ziraat, eğitim, hukuk)
        // 11. bölüm hiç yok: kaynak o fakültelere tablo vermiyor.
        ->and($puan('akdeniz-2026'))->toBe(0);
});

test('Akdeniz 11. bölüm tavanı kadroya göre asgari puandan türetiliyor', function () {
    $depo = sartDepo();

    // Yurt dışı kişisel etkinlik (11.4.2) 75 puan; üç tanesi 225 eder.
    $faaliyetler = array_fill(0, 3, sartFaaliyet(
        'Kişisel Etkinlik (Uluslararası)', Kategori::SanatselEtkinlik, null,
    ));

    $topla = function (string $cetvel) use ($depo, $faaliyetler): int {
        $katalog = $depo->katalog($cetvel);

        return $katalog === null ? -1 : $katalog->topla($faaliyetler, $katalog->coz(['BOLUM_11_DISIPLIN']));
    };

    // "Bu bölümden alınan puan diğer bölümlerden alınan puanın %40'ını
    // geçemez" → %40 × makale oranı × asgari puan.
    expect($topla('akdeniz-2026-guzel-sanatlar-dr'))->toBe(16)
        ->and($topla('akdeniz-2026-guzel-sanatlar-docent'))->toBe(48)
        ->and($topla('akdeniz-2026-guzel-sanatlar-profesor'))->toBe(80)
        // Güzel Sanatlar dışındaki alanlarda makale oranı %50, tavan da yüksek.
        ->and($topla('akdeniz-2026-sosyal-dr'))->toBe(20)
        ->and($topla('akdeniz-2026-sosyal-profesor'))->toBe(100);
});

test('Akdeniz 11.6.1 TV/radyo satırının kendi tavanı bölüm tavanından önce kesiyor', function () {
    $katalog = sartDepo()->katalog('akdeniz-2026-ilahiyat-profesor');
    expect($katalog)->not->toBeNull();

    // 11.6.1 satırı 10 puan; kaynak "bu etkinlikten en fazla 50 puan" diyor.
    // Bölüm tavanı profesörlükte 100, yani kesen şey satırın kendi tavanı.
    $konusmalar = array_fill(0, 9, sartFaaliyet(
        'Bilim İletişimi / Popüler Yayın', Kategori::ToplumsalKatki, null,
    ));

    expect($katalog->topla($konusmalar, $katalog->coz(['BOLUM_11_DISIPLIN'])))->toBe(50);
});

test('Akdeniz eşikleri temel alana göre kendi 11. bölüm cetvelini buluyor', function () {
    $depo = sartDepo();

    $cetvel = fn (string $alan): ?string => $depo->bul('Akdeniz Üniversitesi', 'dr_ogr_uyesi', $alan)['cetvel'] ?? null;

    expect($cetvel('spor'))->toBe('akdeniz-2026-spor-dr')
        ->and($cetvel('mimarlik'))->toBe('akdeniz-2026-mimarlik-dr')
        ->and($cetvel('sosyal'))->toBe('akdeniz-2026-sosyal-dr')
        ->and($cetvel('filoloji'))->toBe('akdeniz-2026-edebiyat-dr')
        ->and($cetvel('guzel_sanatlar'))->toBe('akdeniz-2026-guzel-sanatlar-dr')
        ->and($cetvel('ilahiyat'))->toBe('akdeniz-2026-ilahiyat-dr')
        // Kendi tablosu olmayan alanlar bölünmedi, temel cetvelde kaldı.
        ->and($cetvel('saglik'))->toBe('akdeniz-2026')
        ->and($cetvel('hukuk'))->toBe('akdeniz-2026')
        ->and($cetvel('egitim'))->toBe('akdeniz-2026');
});

/**
 * AKDENİZ 8-10. BÖLÜMLER.
 *
 * 8. bölümün tavanı ("Bu kategoriden en fazla 100 puan alınır") üst simgesi
 * yalnız 8.1'de duruyor ama "kategori" bölümün kendisi; bölüm geneline
 * yazmak aynı zamanda sıkı olan okuma.
 */
test('Akdeniz 8. bölüm tavanı 100 puanda kesiyor', function () {
    $katalog = sartDepo()->katalog('akdeniz-2026');
    expect($katalog)->not->toBeNull();

    // 8.2 yıl başına 30 puan; beş yıllık görev ham 150 eder.
    $gorev = array_fill(0, 5, sartFaaliyet(
        'Akreditasyon Kurulu Görevi', Kategori::EgitimOgretim, null,
    ));

    expect($katalog->topla($gorev, $katalog->coz(['BOLUM_8_EGITIM'])))->toBe(100);
});

/**
 * `Akreditasyon Kurulu Görevi` 04.09.2026'da sözlüğe eklendi.
 *
 * Akdeniz 8.2 (YÖKAK kurulunda görev, 30 x yıl) ile 8.5/8.6 (eğitici eğitimi
 * ve ölçme değerlendirme BELGESİ, 10 ve 5) tek etikette toplansaydı §0
 * uyarınca en düşük kademe yazılmak zorunda kalınır, 8.2 yok olurdu.
 */
test('akreditasyon kurulu görevi dar etiketi eski cetvellerde de puan alıyor', function () {
    $depo = sartDepo();
    $kurul = sartFaaliyet('Akreditasyon Kurulu Görevi', Kategori::EgitimOgretim, null);
    $belge = sartFaaliyet('Akreditasyon Faaliyeti', Kategori::EgitimOgretim, null);

    $akdeniz = $depo->katalog('akdeniz-2026');
    expect($akdeniz)->not->toBeNull();

    expect($akdeniz->puan($kurul, $akdeniz->coz(['BOLUM_8_EGITIM'])))->toBe(30)
        ->and($akdeniz->puan($belge, $akdeniz->coz(['BOLUM_8_EGITIM'])))->toBe(5);

    // Dar etiketi tanımayan cetvelde karşılık aranıyor: OMÜ 14.4 yalnız
    // `Akreditasyon Faaliyeti` taşıyor ama kaydını daha doğru etiketleyen
    // aday yine 6 puanını alıyor. (Karşılık `topla()` yolunda aranıyor;
    // `puan()` yalnız doğrudan eşleşmeye bakar.)
    $omu = $depo->katalog('omu-2025');
    expect($omu)->not->toBeNull();
    expect($omu->topla([$kurul], $omu->coz(['*'])))->toBe(6)
        ->and($omu->topla([$belge], $omu->coz(['*'])))->toBe(6);
});

test('Akdeniz 9. bölüm ödülleri etiketin taşıyabildiği kademeden yazıldı', function () {
    $depo = sartDepo();
    $odul = fn (string $kaynak) => sartFaaliyet($kaynak, Kategori::Odul, null);

    $akdeniz = $depo->katalog('akdeniz-2026');
    expect($akdeniz)->not->toBeNull();
    $hepsi = $akdeniz->coz(['*']);

    // 9.1 TÜBA 1000 ile 9.2 TÜBİTAK 750 tek etiketi paylaşıyor → 750.
    expect($akdeniz->puan($odul('TÜBİTAK / TÜBA Ödülü'), $hepsi))->toBe(750)
        ->and($akdeniz->puan($odul('Uluslararası Bilim/Sanat Ödülü'), $hepsi))->toBe(500)
        ->and($akdeniz->puan($odul('TÜBA GEBİP / TWAS Teşvik Ödülü'), $hepsi))->toBe(500);

    // 9. bölüm dipnot 1: aynı ödül disipline özgü bölümde de varsa YÜKSEK
    // olan geçerli. Mimarlık varyantındaki 11.2.3 (125) bu yüzden 9.3'ün
    // altında kalıyor.
    $mimarlik = $depo->katalog('akdeniz-2026-mimarlik-dr');
    expect($mimarlik)->not->toBeNull();
    expect($mimarlik->puan($odul('Uluslararası Bilim/Sanat Ödülü'), $mimarlik->coz(['*'])))->toBe(500);
});

/**
 * 9.9/9.10 YABANCI UYRUKLU öğrenci tez danışmanlığına 25/15 veriyor; etiket
 * öğrencinin uyruğunu taşımadığı için satırlar girilmedi. Girilselerdi 5.1 ve
 * 5.3'ü bastırıp HER tez danışmanlığını yükseltirlerdi.
 */
test('Akdeniz tez danışmanlığı puanı 9. bölümle şişmiyor', function () {
    $katalog = sartDepo()->katalog('akdeniz-2026');
    expect($katalog)->not->toBeNull();
    $hepsi = $katalog->coz(['*']);

    $tez = fn (string $kaynak) => sartFaaliyet($kaynak, Kategori::TezDanismanligi, null);

    expect($katalog->puan($tez('Doktora Tezi'), $hepsi))->toBe(15)
        ->and($katalog->puan($tez('Yüksek Lisans Tezi'), $hepsi))->toBe(7);
});

test('Akdeniz 10. bölüm toplumsal destek projesi en düşük kademeden yazıldı', function () {
    $katalog = sartDepo()->katalog('akdeniz-2026');
    expect($katalog)->not->toBeNull();

    // 10.1 (bütçeli, iki ay süreli) 100 · 10.2 (hedefi ve çıktıları olan) 20.
    // Tek `Topluma Hizmet Projesi` etiketi bütçe/süre eşiğini ayıramıyor.
    $proje = sartFaaliyet('Topluma Hizmet Projesi', Kategori::ToplumsalKatki, null);

    expect($katalog->puan($proje, $katalog->coz(['BOLUM_10_TOPLUMSAL'])))->toBe(20);
});

/**
 * OMÜ 15. BÖLÜM İLETİŞİM FAKÜLTESİNE ÖZGÜ.
 *
 * Kaynağın bölüm başlığı "15. GÖRSEL ETKİNLİKLER (İletişim Fakültesi için
 * geçerlidir)" diyor. Kısıt faaliyetin niteliği değil ADAYIN BİRİMİNİN
 * durumu; hiçbir sözlük etiketi taşıyamıyor. B grubunun barajı ise "1-15
 * kategorilerinden" olduğu için hukuk, ilahiyat, spor, eğitim ve filoloji
 * adayları da bu puanı topluyordu.
 */
test('OMÜ görsel etkinlik puanı yalnız sosyal alanda sayılıyor', function () {
    $depo = sartDepo();
    $film = sartFaaliyet('Belgesel/Kısa Film (Uluslararası)', Kategori::SanatselEtkinlik, null);

    $puan = function (string $alan) use ($depo, $film): int {
        $esik = $depo->bul('Ondokuz Mayıs Üniversitesi', 'dr_ogr_uyesi', $alan);
        $katalog = $depo->katalog($esik['cetvel'] ?? '');

        return $katalog === null ? -1 : $katalog->puan($film, $katalog->coz(['*']));
    };

    // İletişim Fakültesi `sosyal` temel alanına düşüyor: 15.2-15.4 → 20 puan.
    expect($puan('sosyal'))->toBe(20)
        // Öteki B alanları 15. bölümü hiç taşımıyor.
        ->and($puan('hukuk'))->toBe(0)
        ->and($puan('ilahiyat'))->toBe(0)
        ->and($puan('spor'))->toBe(0)
        ->and($puan('egitim'))->toBe(0)
        ->and($puan('filoloji'))->toBe(0)
        // A grubunda bölüm zaten barajın (1-14) dışındaydı, artık satırı da yok.
        ->and($puan('fen'))->toBe(0)
        // C grubunun barajı 1-16 diyor ama 15. bölüm ona da ait değil.
        ->and($puan('guzel_sanatlar'))->toBe(0);
});

test('OMÜ B grubunun iki kaydı da aynı ölçütü uyguluyor', function () {
    $depo = sartDepo();

    $sart = fn (string $alan): array => $depo->bul('Ondokuz Mayıs Üniversitesi', 'dr_ogr_uyesi', $alan)['sart'];

    // Ayrım yalnız cetvelde; şart ağaçları birebir aynı olmalı.
    expect($sart('hukuk'))->toBe($sart('sosyal'));
});

/**
 * BÖLÜM BAŞLIĞINDAKİ PARANTEZ TARAMASI (04.09.2026).
 *
 * Kaynak metinlerin bölüm başlıklarındaki parantezler tarandı; ikisi adayın
 * BİRİMİNE ya da TEMEL ALANINA kısıt koyuyordu ve cetvelde karşılıksızdı.
 */
test('İstanbul Zaim V. bölümü yalnız güzel sanatlar alanında sayılıyor', function () {
    $depo = sartDepo();
    $eser = sartFaaliyet('Eserin Müzeye Kabulü (Yurt Dışı)', Kategori::SanatselEtkinlik, null);

    $puan = function (string $alan) use ($depo, $eser): int {
        $esik = $depo->bul('İstanbul Sabahattin Zaim Üniversitesi', 'docentlik', $alan);
        $katalog = $depo->katalog($esik['cetvel'] ?? '');

        return $katalog === null ? -1 : $katalog->puan($eser, $katalog->coz(['*']));
    };

    // "V. UYGULAMALI FAALİYETLER (Güzel Sanatlar Temel Alanında)" → V.1 100 puan.
    expect($puan('guzel_sanatlar'))->toBe(100)
        ->and($puan('mimarlik'))->toBe(0)
        ->and($puan('sosyal'))->toBe(0)
        ->and($puan('egitim'))->toBe(0);
});

test('Muş Alparslan konservatuvar bölümü hiçbir alanda sayılmıyor', function () {
    $katalog = sartDepo()->katalog('mus-alparslan-2025');
    expect($katalog)->not->toBeNull();
    $hepsi = $katalog->coz(['*']);

    $sanat = fn (string $kaynak) => sartFaaliyet($kaynak, Kategori::SanatselEtkinlik, null);

    // "E- KONSERVATUAR ETKİNLİKLERİ (Sadece Devlet Konservatuarı için
    // geçerlidir)" — bu yönergenin Madde 5'i güzel sanatlar temel alanını hiç
    // anmadığı için o kadroya eşik de yok; satırlar yalnız hak etmeyen
    // alanlara puan veriyordu.
    expect($katalog->puan($sanat('Senfoni Kompozisyonu'), $hepsi))->toBe(0)
        ->and($katalog->puan($sanat('Solistlik (Uluslararası)'), $hepsi))->toBe(0)
        ->and($katalog->puan($sanat('Orkestra / Koro Üyeliği'), $hepsi))->toBe(0)
        // F bölümü (SANAT VE TASARIM ETKİNLİKLERİ) kısıtsız, dokunulmadı.
        ->and($katalog->puan($sanat('Kişisel Etkinlik (Uluslararası)'), $hepsi))->toBe(60);
});

/**
 * SATIR BAŞLIĞINDAKİ PARANTEZ TARAMASI (04.09.2026).
 *
 * Başlık taramasının satır düzeyindeki hâli: kaynak metinlerin TABLO
 * SATIRLARINDA birim/alan/kadro kısıtı taşıyan parantezler arandı. Elli altı
 * işaretin tek gerçek bulgusu Ankara Hacı Bayram Veli'nin 15. bölümü.
 */
test('HBV yarışma bölümü yalnız mimarlık alanında sayılıyor', function () {
    $depo = sartDepo();
    $odul = sartFaaliyet('Yarışma Derecesi / Mansiyon', Kategori::Odul, null);

    $puan = function (string $alan) use ($depo, $odul): int {
        $esik = $depo->bul('Ankara Hacı Bayram Veli Üniversitesi', 'dr_ogr_uyesi', $alan);
        $katalog = $depo->katalog($esik['cetvel'] ?? '');

        return $katalog === null ? -1 : $katalog->puan($odul, $katalog->coz(['*']));
    };

    // "15. Yarışma, Proje ve Yazılım (Mimarlık, Planlama ve Tasarım Temel
    // Alanı İçin)" → 15.a 15 puan.
    expect($puan('mimarlik'))->toBe(15)
        // `hbv-2026-baslica` mimarlığın yanında bu beş alanı da taşıyor.
        ->and($puan('fen'))->toBe(0)
        ->and($puan('muhendislik'))->toBe(0)
        ->and($puan('saglik'))->toBe(0)
        // `hbv-2026-esit` mimarlığı hiç içermiyor.
        ->and($puan('sosyal'))->toBe(0)
        ->and($puan('guzel_sanatlar'))->toBe(0);
});

/**
 * ÜST SİMGE İŞARETİ TARAMASI (04.09.2026): DİPNOT NUMARASI TABLOYA YERELDİR.
 *
 * Akdeniz'in beş değerlendirme grubunun her biri kendi tablosunun altında
 * KENDİ dipnot listesini taşıyor ve numaralar her tabloda BAŞTAN BAŞLIYOR.
 * "En az puan" sütununa bağlı üst simge bu yüzden tablodan tabloya değişik:
 *
 *   GRUP 1  En az puan³ → 3 "Bu puanın en az yarısı 1. Bölüm'den"
 *   GRUP 2  En az puan⁵ → 5 aynı cümle
 *   GRUP 3  En az puan³’⁴ → 3 Hukuk/İlahiyat yarısı · 4 Güzel Sanatlar %40
 *   GRUP 4  En az puan³ → 3 "en az yarısı 11.4'ten" (girilmedi, gerekçesi
 *           yonerge/akdeniz.php başlığında)
 *   GRUP 5  En az puan⁴ → 4 "Bu puanın en az yarısı 1. Bölüm'den"
 *
 * Aynı rakamın aynı belgede farklı şeyler anlatması korpusta YALNIZ burada
 * görülüyor; "dipnot 3 şunu diyor" diye not almak bu dosyada yanıltıcıdır.
 * Test oranları koruyor: yanlış dipnota bakılırsa oran da yanlış olur.
 */
test('Akdeniz makale oranları her grubun kendi dipnotundan geliyor', function () {
    $depo = sartDepo();

    $oran = function (string $alan) use ($depo): ?int {
        $esik = $depo->bul('Akdeniz Üniversitesi', 'dr_ogr_uyesi', $alan);
        $bul = function (array $dugum) use (&$bul): ?int {
            if (($dugum['maddeler'] ?? []) === ['BOLUM_1_MAKALE'] && isset($dugum['min_puan'])) {
                return (int) $dugum['min_puan'];
            }

            foreach ($dugum['cocuklar'] ?? [] as $cocuk) {
                $sonuc = $bul($cocuk);

                if ($sonuc !== null) {
                    return $sonuc;
                }
            }

            return null;
        };

        return $esik === null ? null : $bul($esik['sart']);
    };

    // Dr. Öğr. Üyesinde asgari puan 100; yarısı 50, Güzel Sanatlarda %40'ı 40.
    expect($oran('fen'))->toBe(50)          // GRUP 1 · dipnot 3
        ->and($oran('sosyal'))->toBe(50)    // GRUP 2 · dipnot 5
        ->and($oran('hukuk'))->toBe(50)     // GRUP 3 · dipnot 3
        ->and($oran('ilahiyat'))->toBe(50)  // GRUP 3 · dipnot 3
        ->and($oran('guzel_sanatlar'))->toBe(40) // GRUP 3 · dipnot 4
        ->and($oran('filoloji'))->toBe(50); // GRUP 5 · dipnot 4
});

/**
 * AKDENİZ GRUP 4 — DEVLET KONSERVATUVARI (04.09.2026'da girildi).
 *
 * Ayrım `birim` ile kuruluyor ve ASİMETRİK: konservatuvar kaydı birim
 * taşıyor, GRUP 3'ün güzel sanatlar kaydı taşımıyor. `bul()` iki aday
 * bulunca birimi birebir eşleşeni döndürdüğü için, ikisine de birim
 * yazılsaydı programını boş bırakan güzel sanatlar adayı kapsam dışı
 * kalırdı — mevcut davranış korunmalı.
 */
test('Akdeniz konservatuvar eşiği birimle ayrılıyor, güzel sanatlar kapsamı korunuyor', function () {
    $depo = sartDepo();

    $anahtar = fn (string $kadro, ?string $birim): ?string => $depo->bul(
        'Akdeniz Üniversitesi', $kadro, 'guzel_sanatlar', $birim,
    )['anahtar'] ?? null;

    expect($anahtar('dr_ogr_uyesi', null))->toBe('akdeniz-dr-grup3-gs-guzel_sanatlar')
        ->and($anahtar('dr_ogr_uyesi', 'Antalya Devlet Konservatuvarı'))->toBe('akdeniz-dr-grup4-guzel_sanatlar')
        ->and($anahtar('profesorluk', null))->toBe('akdeniz-profesor-grup3-gs-guzel_sanatlar')
        ->and($anahtar('profesorluk', 'Antalya Devlet Konservatuvarı'))->toBe('akdeniz-profesor-grup4-guzel_sanatlar');

    // Program seçeneği eşik verisinden üretiliyor; profil ekranında yalnız bu
    // görünüyor ve boş bırakmak GRUP 3 demek.
    expect($depo->birimler('Akdeniz Üniversitesi'))->toBe(['Antalya Devlet Konservatuvarı']);
});

test('Akdeniz GRUP 4 barajı 11.4 etkinlikleriyle sağlanabiliyor', function () {
    $depo = sartDepo();
    $esik = $depo->bul('Akdeniz Üniversitesi', 'dr_ogr_uyesi', 'guzel_sanatlar', 'Antalya Devlet Konservatuvarı');

    expect($esik)->not->toBeNull()
        // 11. bölüm tavanı bu varyantta YOK: GRUP 4 puanın yarısını 11.4'ten
        // isterken 16 puanlık tavan eşiği sağlanamaz kılardı.
        ->and($depo->katalog($esik['cetvel'])->grupTavanlari)->not->toHaveKey('BOLUM_11_DISIPLIN');

    // 11.4.1 (eserin yurt dışı koleksiyonda daimî yer alması) 150 puan;
    // bir makale 15. Toplam 165 ≥ 100 ve 11.4'ten 150 ≥ 50.
    $sonuc = $depo->degerlendir($esik, [
        sartFaaliyet('Eserin Müzeye Kabulü (Yurt Dışı)', Kategori::SanatselEtkinlik, null),
        sartFaaliyet('TR Dizin', Kategori::Makale, 'baslica'),
    ], new Profil(yds: 70));

    $onbirDort = sartDugum($sonuc, '11.4 disipline özgü etkinliklerinizden en az 50 puan');

    expect($onbirDort->gerekli)->toBe(50)
        ->and($onbirDort->mevcut)->toBe(150)
        ->and($onbirDort->durum)->toBe(Durum::Saglandi);
});

/**
 * KARAMANOĞLU FEN GRUBU — BARAJLAR SAYFA GÖRÜNTÜSÜNDEN DOĞRULANDI.
 *
 * Kaynak PDF taranmış ve OCR "%" işaretini "90", "96", "“" diye okuyor; fen
 * grubunun satırı `Enaz “650'si` çıkıyordu. 200 dpi sayfa görüntüsünde
 * (MADDE 6.(3)/b/3, 8.(3)/a, 9.(3)/a) metin net:
 *
 *   Dr.       "En az %50'si A, C, F, H ve İ türü aktivitelerden olmak üzere
 *              bütün aktivitelerden toplam 150 puan almış olmak"
 *   Doçent    "En az %50'sini A, B, C, F, H ve İ türü aktivitelerden olmak
 *              üzere en az 300 puan almış olmak"
 *   Profesör  "Doçent ünvanı aldıktan sonra en az %50'si … en az 350 puan"
 *
 * Yarının tabanı her üçünde de cümledeki SABİT sayı, adayın kendi toplamı
 * değil — bu yüzden düğümler `puanDan` (75 · 150 · 175).
 */
test('Karamanoğlu fen grubunun barajları ve tür tabanları kaynakla birebir', function () {
    $depo = sartDepo();

    $puanlar = function (string $anahtar) use ($depo): array {
        $esik = $depo->esik($anahtar);
        $out = [];
        $gez = function (array $dugum) use (&$gez, &$out): void {
            if (($dugum['tip'] ?? null) === 'puan') {
                $out[] = $dugum['min_puan'] ?? 0;
            }

            foreach ($dugum['cocuklar'] ?? [] as $cocuk) {
                $gez($cocuk);
            }
        };
        $gez($esik['sart'] ?? []);

        return $out;
    };

    // Dr: toplam 150, A/C/F/H/İ türlerinden 75.
    expect($puanlar('kmu-fen-dr-fen'))->toBe([150, 75])
        // Doçent: toplam 300 · türlerden 150; "(a)'ya İLAVETEN 100 puan daha"
        // alternatifi ise toplamı 400'e, tür kümesini 250'ye çıkarıyor.
        ->and($puanlar('kmu-fen-docent-fen'))->toBe([300, 150, 400, 250])
        // Profesör: 350 · 175; fen grubunda ilave 150 (öteki üç grupta 100).
        ->and($puanlar('kmu-fen-profesor-fen'))->toBe([350, 175, 500, 325]);
});

/**
 * "İLAVE … PUAN DAHA" TELAFİSİ İKİ KOŞUL DEMEK (Dicle).
 *
 * Kaynak: "…doktor öğretim üyeliğine yeniden atanma koşullarında istenilen
 * asgari 40 puana ilaveten A1-D2 kodları arasındaki faaliyetlerden 20 puan
 * daha alarak puanlarını 60'a TAMAMLAMALARI gerekir." Ek puan hem belirli
 * bir kümeden gelmeli hem de toplamı yükseltiyor. İlk yazımda tek düğüme
 * sığdırılıp "A1-D2'den 60 puan" diye yazılmıştı — kaynağın istemediği
 * kadar sıkıydı; doçentlik ve profesörlükte ise tersi olmuş, ek puan
 * kümeye yazılıp toplamın yükseldiği atlanmıştı.
 */
test('Dicle telafi yolu hem kümeyi hem toplamı yükseltiyor', function () {
    $depo = sartDepo();
    $esik = $depo->esik('dicle-spor-dr-yeniden-spor');

    expect($esik)->not->toBeNull();

    $telafi = null;
    $ara = function (array $dugum) use (&$ara, &$telafi): void {
        if (isset($dugum['telafi']) && str_contains($dugum['aciklama'] ?? '', 'proje ekibinde')) {
            $telafi = $dugum['telafi'];
        }

        foreach ($dugum['cocuklar'] ?? [] as $cocuk) {
            $ara($cocuk);
        }
    };
    $ara($esik['sart']);

    expect($telafi)->not->toBeNull()
        ->and($telafi['tip'])->toBe('ve');

    $puanlar = array_map(fn (array $c): int => $c['min_puan'] ?? 0, $telafi['cocuklar']);

    // Toplam 60'a tamamlanacak, ek 20 puan A1-D2 kümesinden gelecek.
    expect($puanlar)->toBe([60, 20]);
});

/**
 * ISPARTA ÜBÜ — "İLAVETEN" KALIBININ REFERANS UYGULAMASI.
 *
 * Yönergede kalıbın dört örneği var ve dördü de eksiksiz yazılmış; korpusta
 * bu kalıbın doğru kurulduğu tek yer burası, o yüzden teste bağlandı.
 *
 *   6/4-a   "Tablo 1'den en az 40 puan almak şartıyla, Tablo 1 ve Tablo 2'den
 *            toplamda asgari 60 puan"
 *   6/4-b-5 "Madde 6/4-a bendine ilaveten, Tablo 1'den en az 20 puan"
 *            → Tablo 1 tabanı 40 + 20 = 60. Tek düğüm YETER, çünkü ek puan
 *            zaten (a)'nın kısıtladığı KÜMEDEN geliyor ve toplam kendiliğinden
 *            60'ın üstünde kalıyor.
 *   7/2-b-9 "Madde 7/2-a'daki puana ilaveten Tablo 1'den en az 10 ve Tablo
 *            2'den en az 10 puan olacak şekilde toplamda en az 20 puan"
 *            → burada ek puan İKİ ayrı kümeye bölünüyor ve (a)'nın tabanı
 *            tablo bazında değil TOPLAM (100). Üç düğüm gerekiyor:
 *            T1 ≥ 10, T2 ≥ 10, toplam ≥ 120.
 *   8/2-b-8 (a) "Tablo 1'den en az 60, toplamda en az 120" + ilave 10/10/20
 *            → T1 ≥ 70, T2 ≥ 10, toplam ≥ 140.
 */
test('Isparta ÜBÜ "ilaveten" bentleri kaynaktaki tabanla toplanmış', function () {
    $depo = sartDepo();

    $dugumler = function (string $anahtar, string $madde) use ($depo): array {
        $esik = $depo->esik($anahtar);
        $out = [];
        $gez = function (array $dugum) use (&$gez, &$out, $madde): void {
            if (($dugum['tip'] ?? null) === 'puan' && ($dugum['madde'] ?? '') === $madde) {
                $out[implode(',', $dugum['maddeler'] ?? [])] = $dugum['min_puan'] ?? 0;
            }

            foreach ($dugum['cocuklar'] ?? [] as $cocuk) {
                $gez($cocuk);
            }
        };
        $gez($esik['sart'] ?? []);

        return $out;
    };

    // 6/4-b-5: taban 40 + ilave 20 = 60, tek küme.
    expect($dugumler('isparta-ubu-sosyal-dr-sosyal', 'MADDE 6/4-b-5'))->toBe(['T1' => 60])
        // 6/2-c-6: fen tarafında aynı yapı.
        ->and($dugumler('isparta-ubu-fen-muh-dr-fen', 'MADDE 6/2-c-6'))->toBe(['T1' => 60]);

    // 7/2-b-9 ve 8/2-b-8: ek puan iki kümeye bölünüyor, toplam da yükseliyor.
    $docent = $dugumler('isparta-ubu-fen-muh-docentlik-fen', 'MADDE 7/2-b-9');
    $profesor = $dugumler('isparta-ubu-fen-muh-profesorluk-fen', 'MADDE 8/2-b-8');

    expect($docent)->toBe(['T1' => 10, 'T2' => 10])
        ->and($profesor)->toBe(['T1' => 70, 'T2' => 10]);

    // Toplam düğümleri `Kalip::toplam` ile yazıldığı için `madde` taşımıyor;
    // ilave yolunun toplamı ayrıca doğrulanıyor.
    $toplamlar = function (string $anahtar) use ($depo): array {
        $esik = $depo->esik($anahtar);
        $out = [];
        $gez = function (array $dugum) use (&$gez, &$out): void {
            if (($dugum['tip'] ?? null) === 'puan' && str_contains($dugum['aciklama'] ?? '', 'toplam en az')) {
                $out[] = $dugum['min_puan'] ?? 0;
            }

            foreach ($dugum['cocuklar'] ?? [] as $cocuk) {
                $gez($cocuk);
            }
        };
        $gez($esik['sart'] ?? []);
        sort($out);

        return $out;
    };

    // Doçentlikte 100 (ana) + 120 (ilave yolu), profesörlükte 120 + 140.
    expect($toplamlar('isparta-ubu-fen-muh-docentlik-fen'))->toBe([100, 120])
        ->and($toplamlar('isparta-ubu-fen-muh-profesorluk-fen'))->toBe([120, 140]);
});

/**
 * GAZİANTEP — "İLAVETEN" TELAFİLERİ (b)/(c) BENDİNİN TABANINA EKLENİR.
 *
 * Kaynak her alanda aynı iki bendi taşıyor:
 *   (c)/(b)  "1(a) nolu maddeden … en az T puan, 4 numaralı maddeden en az
 *             12 ve genel toplamda en az … puan almış olmak."
 *   proje    "5 nolu maddeden (BAP hariç) en az N puan. Bu şartı
 *             sağlayamayanların (c) bendinde belirtilen PUANA İLAVETEN
 *             1(a) kapsamındaki dergilerden en az N puan DAHA almış olması."
 *   (d/e).3  "(c) bendinde belirtilen puana ilaveten 1(a) ve/veya 8(a)
 *             maddelerinden toplamda en az 90 puan daha."
 *
 * İlk girişte telafilerin ikisi de TABANA EKLENMEMİŞTİ; üstelik proje
 * telafisine öteki bendin sayısı (90) ve kümesi ({1a,8a}) yazılmıştı.
 */
test('Gaziantep telafileri 1(a) tabanına ekleniyor', function () {
    $depo = sartDepo();

    $telafiler = function (string $anahtar) use ($depo): array {
        $esik = $depo->esik($anahtar);
        $out = [];
        $gez = function (array $dugum) use (&$gez, &$out): void {
            if (($dugum['tip'] ?? null) === 'puan' && str_starts_with($dugum['aciklama'] ?? '', 'Ya da')) {
                $out[] = $dugum['min_puan'] ?? 0;
            }

            foreach ($dugum['cocuklar'] ?? [] as $cocuk) {
                $gez($cocuk);
            }
        };
        $gez($esik['sart'] ?? []);

        return $out;
    };

    // Fen: 1(a) tabanı 240 · proje 45 → 285 · (e).3 90 → 330
    expect($telafiler('gaziantep-docent-fen-fen'))->toBe([285, 330])
        ->and($telafiler('gaziantep-profesor-fen-fen'))->toBe([285, 330])
        // Sağlık doçent: taban 180 · proje 30 → 210 · 90 → 270
        ->and($telafiler('gaziantep-docent-saglik-saglik'))->toBe([210, 270])
        // Sağlık profesör: taban 150 → 180 ve 240
        ->and($telafiler('gaziantep-profesor-saglik-saglik'))->toBe([180, 240]);

    // Sosyal tarafta (b) bendi iki dallı (1a+1c 140 ya da MAKALE 180/200);
    // telafi de iki dalı birden yükseltiyor.
    expect($telafiler('gaziantep-docent-sosyal-sosyal'))->toBe([180, 170, 210])
        ->and($telafiler('gaziantep-profesor-sosyal-sosyal'))->toBe([200, 170, 230]);
});

/**
 * GAZİ — DOKTOR ÖĞRETİM ÜYESİ YENİDEN ATANMA (06.09.2026'da girildi).
 *
 * Kaynağın dört alan grubunun her birinde ayrı bir "yeniden atanma" bölümü
 * var; yürürlükteki "01.01.2024-KALICI" seti alındı. Proje koşulunun
 * telafisi KÜMÜLATİF yazıldı, çünkü kaynak ek puanın "Kriter 1 için sunulan
 * makaleler DIŞINDA" olmasını istiyor ve motor eser ayrıklığını tutamıyor.
 */
test('Gazi yeniden atanma eşikleri kaynaktaki barajları taşıyor', function () {
    $depo = sartDepo();

    $ozet = function (string $alan) use ($depo): array {
        $esik = $depo->bul('Gazi Üniversitesi', 'dr_ogr_uyesi_yeniden', $alan);
        $out = ['toplam' => null, 'kriter1' => null, 'telafi' => null];
        $gez = function (array $dugum) use (&$gez, &$out): void {
            if (($dugum['tip'] ?? null) === 'puan') {
                if (($dugum['madde'] ?? '') === 'Kriter 1') {
                    $out['kriter1'] = $dugum['min_puan'];
                } elseif (str_contains($dugum['aciklama'] ?? '', 'toplam en az')) {
                    $out['toplam'] = $dugum['min_puan'];
                }
            }

            if (isset($dugum['telafi'])) {
                $out['telafi'] = $dugum['telafi']['min_puan'] ?? null;
            }

            foreach ($dugum['cocuklar'] ?? [] as $cocuk) {
                $gez($cocuk);
            }
        };
        $gez($esik['sart'] ?? []);

        return $out;
    };

    // A1 Fen/Mühendislik ve A2 Sağlık: toplam 90, Kriter 1 = 30, telafi 30+30.
    expect($ozet('fen'))->toBe(['toplam' => 90, 'kriter1' => 30, 'telafi' => 60])
        ->and($ozet('saglik'))->toBe(['toplam' => 90, 'kriter1' => 30, 'telafi' => 60])
        // A3 Sosyal ve A4 Mimarlık: toplam 80, Kriter 1 = 20, telafi 20+30.
        ->and($ozet('sosyal'))->toBe(['toplam' => 80, 'kriter1' => 20, 'telafi' => 50])
        ->and($ozet('mimarlik'))->toBe(['toplam' => 80, 'kriter1' => 20, 'telafi' => 50]);
});

test('Gazi yeniden atanmada proje koşulu araştırmacılığı da kabul ediyor', function () {
    $depo = sartDepo();
    $esik = $depo->bul('Gazi Üniversitesi', 'dr_ogr_uyesi_yeniden', 'fen');

    $proje = null;
    $ara = function (array $dugum) use (&$ara, &$proje): void {
        if (($dugum['madde'] ?? '') === 'Kriter 2' && ($dugum['tip'] ?? null) === 'adet') {
            $proje = $dugum;
        }

        foreach ($dugum['cocuklar'] ?? [] as $cocuk) {
            $ara($cocuk);
        }
    };
    $ara($esik['sart']);

    // İlk atamada yalnız yürütücülük sayılıyor; yeniden atanmada araştırmacılık da.
    expect($proje)->not->toBeNull()
        ->and($proje['maddeler'])->toBe(['PROJE-e-haric']);
});

/**
 * FIRAT — GEÇİCİ MADDE 14: ASGARİ PUANLAR KADEMELİ YÜRÜRLÜKTE.
 *
 * Kaynak: "belirtilen DİL PUANI HARİÇ zorunlu asgari puanların, aşağıdaki
 * tabloda verilen tarihlere karşılık gelen oranlarda karşılanması gerekir.
 * Yayın sayıları … küsuratlı olması durumunda ÜST TAM SAYIYA yuvarlanır."
 *
 *     01.06.2026-31.12.2026 %50 · 2027 %75 · 01.01.2028'den sonra %100
 *
 * Tablo hiç girilmemişti; bütün Fırat eşikleri bugün olması gerekenin iki
 * katı baraj istiyordu. Oran TARİHTEN türetiliyor, sabit yazılmıyor — bu
 * yüzden test mutlak değeri değil, ORANIN TABLOYA UYGUNLUĞUNU doğruluyor:
 * takvim ilerleyince veri kendiliğinden düzeliyor, test kırılmıyor.
 */
test('Fırat barajları geçiş oranıyla ölçekleniyor, dil puanı ölçeklenmiyor', function () {
    $depo = sartDepo();
    $esik = $depo->bul('Fırat Üniversitesi', 'dr_ogr_uyesi', 'muhendislik');

    $bugun = date('Y-m-d');
    $oran = match (true) {
        $bugun < '2027-01-01' => 0.50,
        $bugun < '2028-01-01' => 0.75,
        default => 1.0,
    };

    $toplam = collect($esik['sart']['cocuklar'])
        ->first(fn (array $d): bool => ($d['rol'] ?? null) === 'toplam')['min_puan'];

    // Yönergedeki ham baraj 1000.
    expect($toplam)->toBe((int) ceil(1000 * $oran));

    // Dil puanı kaynağın açık istisnası: her zaman 65.
    $yds = null;
    $ara = function (array $dugum) use (&$ara, &$yds): void {
        if (($dugum['metrik'] ?? null) === 'yds') {
            $yds = $dugum['min'];
        }

        foreach ($dugum['cocuklar'] ?? [] as $cocuk) {
            $ara($cocuk);
        }
    };
    $ara($esik['sart']);

    expect($yds)->toBe(65);

    // Yayın SAYILARI da ölçekleniyor ve üste yuvarlanıyor (3 → 2 · %50).
    $adetler = [];
    $topla = function (array $dugum) use (&$topla, &$adetler): void {
        if (isset($dugum['min_adet'])) {
            $adetler[] = $dugum['min_adet'];
        }

        foreach ($dugum['cocuklar'] ?? [] as $cocuk) {
            $topla($cocuk);
        }
    };
    $topla($esik['sart']);

    expect($adetler)->toBe([(int) ceil(3 * $oran)]);
});

/**
 * KOCAELİ — DOKTOR ÖĞRETİM ÜYESİ YENİDEN ATANMA (06.09.2026'da girildi).
 *
 * Madde 11/b'nin üstüne İKİ GEÇİCİ MADDE biniyor ve ikisi de bugün
 * yürürlükte (01/01/2025-31/12/2026): toplam puan şartı %70'e iniyor ve
 * makale şartı hiç aranmıyor. Oran ve muafiyet TARİHTEN türetiliyor, bu
 * yüzden test mutlak değeri değil tarih çözümlemesini doğruluyor.
 */
test('Kocaeli yeniden atanma barajı geçiş hükmüyle ölçekleniyor', function () {
    $depo = sartDepo();

    $geciste = date('Y-m-d') < '2027-01-01';
    $oran = $geciste ? 0.70 : 1.00;

    $ozet = function (string $alan) use ($depo): array {
        $esik = $depo->bul('Kocaeli Üniversitesi', 'dr_ogr_uyesi_yeniden', $alan);
        $toplam = null;
        $makale = false;
        $gez = function (array $dugum) use (&$gez, &$toplam, &$makale): void {
            if (($dugum['rol'] ?? null) === 'toplam') {
                $toplam = $dugum['min_puan'];
            }

            if (str_contains($dugum['aciklama'] ?? '', 'en az bir makale')) {
                $makale = true;
            }

            foreach ($dugum['cocuklar'] ?? [] as $cocuk) {
                $gez($cocuk);
            }
        };
        $gez($esik['sart'] ?? []);

        return ['toplam' => $toplam, 'makale' => $makale];
    };

    // Tablo 2: Dr. Öğr. Üyesi toplam puanı üç alan grubunda 100, güzel
    // sanatlarda 200.
    expect($ozet('fen')['toplam'])->toBe((int) ceil(100 * $oran))
        ->and($ozet('hukuk')['toplam'])->toBe((int) ceil(100 * $oran))
        ->and($ozet('guzel_sanatlar')['toplam'])->toBe((int) ceil(200 * $oran))
        // Geçici Madde 2 yürürlükteyken makale şartı hiç yazılmıyor.
        ->and($ozet('fen')['makale'])->toBe(! $geciste);
});

/**
 * KOCAELİ K BÖLÜMÜ — İDARİ GÖREVLER (06.09.2026'da girildi).
 *
 * Bölüm hiç girilmemişti; Madde 11/b'nin yeniden atanma koşulu ise doğrudan
 * ona atıf yapıyor. Girilince İKİNCİ bir iş çıktı: madde E ve K bölümlerini
 * BİRLİKTE 50 ile sınırlıyor, Tablo 2 ise ayrı ayrı. İki ayrı 50 tavanı
 * yeniden atanmada 100'e kadar puan üretiyordu.
 */
test('Kocaeli idari görev kademeleri etiketin taşıyabildiği en düşük değerde', function () {
    $katalog = sartDepo()->katalog('kocaeli-2023');
    expect($katalog)->not->toBeNull();
    $hepsi = $katalog->coz(['*']);

    $gorev = fn (string $kaynak) => sartFaaliyet($kaynak, Kategori::IdariGorev, null);

    expect($katalog->puan($gorev('Dekan / Enstitü-YO Müdürü'), $hepsi))->toBe(15)
        ->and($katalog->puan($gorev('Bölüm Başkanı'), $hepsi))->toBe(12)
        ->and($katalog->puan($gorev('Bölüm Başkan Yardımcısı'), $hepsi))->toBe(10)
        // K.3 anabilim dalı başkanlığı 10, K.4 koordinatörlük 8; tek etiket → 8.
        ->and($katalog->puan($gorev('Anabilim Dalı Başkanı / Koordinatörlük'), $hepsi))->toBe(8)
        // K.6/K.7/K.8 üç kademe (6/5/4); tek etiket → 4.
        ->and($katalog->puan($gorev('Kurul / Komisyon Üyeliği'), $hepsi))->toBe(4)
        // Rektörlük kaynakta hiç anılmıyor.
        ->and($katalog->puan($gorev('Rektör'), $hepsi))->toBe(0);
});

test('Kocaeli yeniden atanmada ders ve idari görev ortak 50 tavanını paylaşıyor', function () {
    $depo = sartDepo();

    $ortak = $depo->katalog('kocaeli-2023-yeniden');
    $normal = $depo->katalog('kocaeli-2023');
    expect($ortak)->not->toBeNull();

    // Ortak tavan yalnız YENİDEN ATANMA eşiğine bağlı; öteki kadrolar Tablo
    // 2'nin ayrı tavanlarını kullanmaya devam ediyor.
    expect($depo->bul('Kocaeli Üniversitesi', 'dr_ogr_uyesi_yeniden', 'fen')['cetvel'])
        ->toBe('kocaeli-2023-yeniden')
        ->and($depo->bul('Kocaeli Üniversitesi', 'dr_ogr_uyesi', 'fen')['cetvel'])
        ->toBe('kocaeli-2023');

    // Beş dekanlık (5 × 15 = 75) ve E bölümünü dolduracak kadar ders.
    $idari = array_fill(0, 5, sartFaaliyet('Dekan / Enstitü-YO Müdürü', Kategori::IdariGorev, null));

    // Normal cetvelde K'nin kendi tavanı 50; yeniden atanma cetvelinde ortak
    // tavan yine 50 ama E ile PAYLAŞILIYOR.
    expect($normal->topla($idari, $normal->coz(['K.1-K.11'])))->toBe(50)
        ->and($ortak->topla($idari, $ortak->coz(['E-K'])))->toBe(50)
        // Ortak tavan grubu hem E hem K satırlarını kapsıyor.
        ->and(count($ortak->coz(['E-K'])))->toBeGreaterThan(count($ortak->coz(['K.1-K.11'])));
});
