<?php

use App\Livewire\FaaliyetEkle;
use App\Models\Faaliyet;
use App\Models\User;
use App\Services\Yayin\DergiParkArsivi;
use App\Services\Yayin\KaynakOnerici;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;

/**
 * DergiPark arşiv sayfasının yapısı: her sayı kendi bağlantısıyla başlıyor,
 * yayım tarihi o bağlantının ARDINDAN geliyor.
 *
 * @param  list<array{id: string, etiket: string, tarih?: string}>  $sayilar
 */
function arsivSayfasi(array $sayilar, string $ad = 'Deneme Dergisi', string $kisaltma = 'deneme'): string
{
    $kartlar = implode('', array_map(fn (array $s): string => sprintf(
        '<div class="card"><a href="/tr/pub/%s/issue/%s" class="x">%s</a><span><i></i> %s </span></div>',
        $kisaltma,
        $s['id'],
        $s['etiket'],
        $s['tarih'] ?? '',
    ), $sayilar));

    return "<html><body><h1 class=\"t\">{$ad}</h1><div>{$kartlar}</div></body></html>";
}

/**
 * Sayı sayfası: başlık bağlantısı + yalnız `author-meta-container` içindeki
 * span'lerde yazar adları.
 *
 * @param  list<array{id: string, baslik: string, yazarlar: list<string>}>  $makaleler
 */
function sayiSayfasi(array $makaleler, string $kisaltma = 'deneme'): string
{
    $kartlar = implode('', array_map(function (array $m) use ($kisaltma): string {
        $spanlar = implode(', ', array_map(fn (string $y): string => "<span >{$y} </span>", $m['yazarlar']));

        return sprintf(
            '<a href="/tr/pub/%s/article/%s" class="art-title block"> %s </a>'
            .'<div class="art-meta"><div class="author-meta-container">%s</div></div>',
            $kisaltma,
            $m['id'],
            $m['baslik'],
            $spanlar,
        );
    }, $makaleler));

    // Yazar bloğu DIŞINDA bir span: ayrıştırıcı bunu yazar sanmamalı.
    return "<html><body><span>Tuzak Yazar</span>{$kartlar}</body></html>";
}

function arsivServisi(): DergiParkArsivi
{
    return new DergiParkArsivi;
}

// ─────────────────────────── AYRIŞTIRMA ───────────────────────────

test('dergi adresi de kısaltması da tanınıyor', function () {
    $a = arsivServisi();

    expect($a->kisaltma('https://dergipark.org.tr/tr/pub/politeknik'))->toBe('politeknik')
        ->and($a->kisaltma('https://dergipark.org.tr/tr/pub/politeknik/archive'))->toBe('politeknik')
        ->and($a->kisaltma('  Politeknik '))->toBe('politeknik')
        ->and($a->kisaltma('https://baska.site/dergi'))->toBeNull()
        ->and($a->kisaltma(''))->toBeNull();
});

/**
 * Tarih arşiv sayfasından okunuyor: yıl süzgeci her sayıyı tek tek açmadan
 * kurulabilsin diye. Henüz yayımlanmamış sayının tarihi yok.
 */
test('arşiv sayıları tarihleriyle okunuyor', function () {
    Http::fake(['dergipark.org.tr/tr/pub/*/archive' => Http::response(arsivSayfasi([
        ['id' => '104341', 'etiket' => 'Cilt: 29 Sayı: 3'],
        ['id' => '33001', 'etiket' => 'Cilt: 5 Sayı: 2', 'tarih' => '1.06.2002'],
        ['id' => '33000', 'etiket' => 'Cilt: 5 Sayı: 1', 'tarih' => '1.03.2002'],
    ]))]);

    $sayilar = arsivServisi()->sayilar('deneme');

    expect(arsivServisi()->ad('deneme'))->toBe('Deneme Dergisi')
        ->and($sayilar)->toHaveCount(3)
        ->and($sayilar[0])->toBe(['id' => '104341', 'etiket' => 'Cilt: 29 Sayı: 3', 'tarih' => null, 'yil' => null])
        ->and($sayilar[2])->toBe(['id' => '33000', 'etiket' => 'Cilt: 5 Sayı: 1', 'tarih' => '2002-03-01', 'yil' => 2002]);
});

test('sayıdaki makaleler ve yazarlar okunuyor', function () {
    Http::fake(['dergipark.org.tr/tr/pub/*/issue/*' => Http::response(sayiSayfasi([
        ['id' => '366869', 'baslik' => 'CRAMER-RAO ALT SINIRI', 'yazarlar' => ['Elif Derya Übeyli', 'İnan Güler']],
        ['id' => '366870', 'baslik' => 'DERS İÇERİĞİ', 'yazarlar' => ['Ömer Faruk Bay']],
    ]))]);

    $makaleler = arsivServisi()->makaleler('deneme', '33000');

    expect($makaleler)->toHaveCount(2)
        ->and($makaleler[0]['id'])->toBe('366869')
        ->and($makaleler[0]['baslik'])->toBe('CRAMER-RAO ALT SINIRI')
        // "Tuzak Yazar" yazar bloğunun dışında; listeye girmemeli.
        ->and($makaleler[0]['yazarlar'])->toBe(['Elif Derya Übeyli', 'İnan Güler'])
        ->and($makaleler[1]['yazarlar'])->toBe(['Ömer Faruk Bay']);
});

/**
 * Aday bir arşivde onlarca sayı tarıyor; aynı sayfa iki kez inmemeli.
 */
test('okunan sayfa önbellekten geliyor', function () {
    Http::fake([
        'dergipark.org.tr/tr/pub/*/archive' => Http::response(arsivSayfasi([['id' => '1', 'etiket' => 'C1', 'tarih' => '1.01.2010']])),
        'dergipark.org.tr/tr/pub/*/issue/*' => Http::response(sayiSayfasi([['id' => '9', 'baslik' => 'X', 'yazarlar' => ['A B']]])),
    ]);

    arsivServisi()->sayilar('deneme');
    arsivServisi()->ad('deneme');
    arsivServisi()->makaleler('deneme', '1');
    arsivServisi()->makaleler('deneme', '1');

    Http::assertSentCount(2);
});

// ─────────────────────────── EKRAN ───────────────────────────

/**
 * @param  list<array{id: string, etiket: string, tarih?: string}>  $sayilar
 * @param  array<string, list<array{id: string, baslik: string, yazarlar: list<string>}>>  $icerik
 */
function dergiTaklidi(array $sayilar, array $icerik): void
{
    Http::fake([
        'dergipark.org.tr/tr/pub/*/archive' => Http::response(arsivSayfasi($sayilar)),
        'dergipark.org.tr/tr/pub/*/issue/*' => function ($istek) use ($icerik) {
            $id = (string) str($istek->url())->afterLast('/');

            return Http::response(sayiSayfasi($icerik[$id] ?? []));
        },
    ]);
}

/**
 * Tarama adayın ADINA göre süzülüyor: arşivde yüzlerce makale var, aday
 * kendi yayınını arıyor. Ölçüt soyad — bkz. AdEslestirici.
 */
test('arşiv taraması yalnız adayın yayınlarını getiriyor', function () {
    $kullanici = User::factory()->create(['name' => 'İnan Güler']);

    dergiTaklidi(
        [['id' => '33000', 'etiket' => 'Cilt: 5 Sayı: 1', 'tarih' => '1.03.2002']],
        ['33000' => [
            ['id' => '1', 'baslik' => 'Benim makalem', 'yazarlar' => ['Elif Derya Übeyli', 'İnan Güler']],
            ['id' => '2', 'baslik' => 'Başkasının makalesi', 'yazarlar' => ['Ahmet Yılmaz']],
        ]],
    );

    $bilesen = Livewire::actingAs($kullanici)->test(FaaliyetEkle::class)
        ->set('sekme', 'yayin')
        ->set('arsivDergi', 'deneme')
        ->call('arsivTara')
        ->assertSee('Benim makalem')
        ->assertDontSee('Başkasının makalesi')
        // Ölçüt soyad; "adınızla eşleşti" demek adaya yanlış güven verirdi.
        ->assertSee('soyadınızla eşleşti');

    $bulunan = $bilesen->get('arsivBulunanlar');

    expect($bulunan)->toHaveCount(1)
        ->and($bulunan[0]['sira'])->toBe(2)
        ->and($bulunan[0]['tarih'])->toBe('2002-03-01')
        ->and($bulunan[0]['sayi'])->toBe('Cilt: 5 Sayı: 1');
});

test('yıl aralığı dışındaki sayılar hiç açılmıyor', function () {
    $kullanici = User::factory()->create(['name' => 'İnan Güler']);

    dergiTaklidi([
        ['id' => '2002', 'etiket' => 'C5', 'tarih' => '1.03.2002'],
        ['id' => '2020', 'etiket' => 'C23', 'tarih' => '1.03.2020'],
    ], [
        '2002' => [['id' => '1', 'baslik' => 'Eski makalem', 'yazarlar' => ['İnan Güler']]],
        '2020' => [['id' => '2', 'baslik' => 'Yeni makalem', 'yazarlar' => ['İnan Güler']]],
    ]);

    Livewire::actingAs($kullanici)->test(FaaliyetEkle::class)
        ->set('sekme', 'yayin')
        ->set('arsivDergi', 'deneme')
        ->set('arsivYilSon', '2010')
        ->call('arsivTara')
        ->assertSee('Eski makalem')
        ->assertDontSee('Yeni makalem')
        ->assertSet('arsivTaranan', 1);
});

/**
 * 105 sayılık bir arşiv tek istekte 105 sayfa indirmek demek; hem adayı
 * bekletir hem DergiPark'a kabalık olur. Öbek öbek gidiliyor.
 */
test('arşiv öbek öbek taranıyor ve devam edilebiliyor', function () {
    $kullanici = User::factory()->create(['name' => 'İnan Güler']);

    $sayilar = [];
    $icerik = [];

    foreach (range(1, 15) as $n) {
        $sayilar[] = ['id' => (string) $n, 'etiket' => "Sayı {$n}", 'tarih' => '1.03.2002'];
        // Makale kimliği SAYI olmalı: DergiPark'ta öyle ve ayrıştırıcı da
        // /article/(\d+) arıyor.
        $icerik[(string) $n] = [['id' => (string) (900 + $n), 'baslik' => "Makale {$n}", 'yazarlar' => ['İnan Güler']]];
    }

    dergiTaklidi($sayilar, $icerik);

    $bilesen = Livewire::actingAs($kullanici)->test(FaaliyetEkle::class)
        ->set('sekme', 'yayin')
        ->set('arsivDergi', 'deneme')
        ->call('arsivTara')
        ->assertSet('arsivTaranan', 12)
        ->assertSee('3 sayı daha var');

    expect($bilesen->get('arsivKalan'))->toHaveCount(3);

    $bilesen->call('arsivDevam')->assertSet('arsivTaranan', 15);

    expect($bilesen->get('arsivBulunanlar'))->toHaveCount(15)
        ->and($bilesen->get('arsivKalan'))->toBe([]);
});

/**
 * Crossref'ten gelenlerle aynı kural: kaynak boş, durum beklemede. Tarih
 * sayının yayım tarihinden geliyor — dönem koşulları tarih olmadan karara
 * bağlanamıyor.
 */
test('arşivden seçilen yayın beklemede ve kaynaksız ekleniyor', function () {
    $kullanici = User::factory()->create(['name' => 'İnan Güler']);

    dergiTaklidi(
        [['id' => '33000', 'etiket' => 'Cilt: 5 Sayı: 1', 'tarih' => '1.03.2002']],
        ['33000' => [['id' => '366869', 'baslik' => 'Eski makalem', 'yazarlar' => ['İnan Güler', 'Elif Übeyli']]]],
    );

    Livewire::actingAs($kullanici)->test(FaaliyetEkle::class)
        ->set('sekme', 'yayin')
        ->set('arsivDergi', 'deneme')
        ->call('arsivTara')
        ->set('arsivSecilenler', ['deneme:366869'])
        ->call('arsivdenEkle');

    $faaliyet = $kullanici->faaliyetler()->sole();

    expect($faaliyet->durum)->toBe('beklemede')
        ->and($faaliyet->kaynak)->toBeNull()
        ->and($faaliyet->kategori->value)->toBe('makale')
        ->and($faaliyet->baslik)->toBe('Eski makalem')
        ->and($faaliyet->rol)->toBe('ilk')
        ->and($faaliyet->tarih->format('Y-m-d'))->toBe('2002-03-01')
        ->and($faaliyet->meta['dergi'])->toBe('Deneme Dergisi')
        ->and($faaliyet->meta['dergipark'])->toBe('deneme')
        ->and($faaliyet->meta['dergipark_makale'])->toBe('366869');
});

test('zaten eklenmiş arşiv yayını işaretlenemiyor', function () {
    $kullanici = User::factory()->create(['name' => 'İnan Güler']);

    Faaliyet::factory()->for($kullanici)->create([
        'meta' => ['dergipark' => 'deneme', 'dergipark_makale' => '366869'],
    ]);

    dergiTaklidi(
        [['id' => '33000', 'etiket' => 'C5', 'tarih' => '1.03.2002']],
        ['33000' => [['id' => '366869', 'baslik' => 'Eski makalem', 'yazarlar' => ['İnan Güler']]]],
    );

    $bilesen = Livewire::actingAs($kullanici)->test(FaaliyetEkle::class)
        ->set('sekme', 'yayin')
        ->set('arsivDergi', 'deneme')
        ->call('arsivTara')
        ->assertSee('Zaten ekli');

    expect($bilesen->get('arsivBulunanlar')[0]['ekli'])->toBeTrue();

    $bilesen->set('arsivSecilenler', ['deneme:366869'])->call('arsivdenEkle');

    expect($kullanici->faaliyetler()->count())->toBe(1);
});

test('tanınmayan dergi adresi ekranı çökertmiyor', function () {
    $kullanici = User::factory()->create();
    Http::fake();

    Livewire::actingAs($kullanici)->test(FaaliyetEkle::class)
        ->set('sekme', 'yayin')
        ->set('arsivDergi', 'https://baska.site/dergi')
        ->call('arsivTara')
        ->assertOk()
        ->assertSee('kısaltmasını tanıyamadım');

    Http::assertNothingSent();
});

/**
 * FAZ 2 İLE BİRLEŞME: arşivden gelen kaydın DOI'si yok, ama künyesinde
 * dergi kısaltması var. İndeks önerisi DOI çözmeden doğrudan o kısaltmayla
 * çalışmalı — yoksa eski yayınlar öneriden mahrum kalırdı.
 */
test('arşivden gelen kayda doi olmadan indeks önerilebiliyor', function () {
    $kullanici = User::factory()->create();

    Http::fake(['dergipark.org.tr/tr/pub/*/indexes' => Http::response(
        '<html><head><title>Dizinler - D - D</title></head><body>'
        .'<h3>Atıf Dizinleri</h3><table><tbody><tr><td><a href="#">'
        .'Emerging Sources Citation Index (ESCI)</a></td></tr></tbody></table></body></html>'
    )]);

    $faaliyet = Faaliyet::factory()->for($kullanici)->create([
        'kategori' => 'makale',
        'kaynak' => null,
        'meta' => ['dergipark' => 'deneme', 'dergipark_makale' => '1'],
    ]);

    expect(app(KaynakOnerici::class)->oner($faaliyet)['kaynak'])->toBe('ESCI');

    // DOI çözülmeye çalışılmadı.
    Http::assertSentCount(1);
});
