<?php

use App\Livewire\FaaliyetEkle;
use App\Models\Dergi;
use App\Models\Faaliyet;
use App\Models\User;
use App\Services\Yayin\DergiParkDizinleri;
use App\Services\Yayin\KaynakOnerici;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;

/**
 * DergiPark dizin sayfasının yapısı: <h3>Bölüm</h3> ardından bir tablo,
 * her satırda iki bağlantı — ilki logo görseli (metinsiz), ikincisi ad.
 *
 * @param  list<string>  $atif
 * @param  list<string>  $diger
 */
function dizinSayfasi(array $atif, array $diger = [], string $ad = 'Deneme Dergisi'): string
{
    $tablo = function (string $baslik, array $adlar): string {
        if ($adlar === []) {
            return '';
        }

        $satirlar = implode('', array_map(fn (string $x): string => <<<HTML
            <tr>
                <td><a href="https://ornek.test"><img alt="{$x}" src="logo.jpg"></a></td>
                <td><a href="https://ornek.test">
                    {$x}
                </a></td>
            </tr>
            HTML, $adlar));

        return "<h3 class=\"x\">{$baslik}</h3><div><table><tbody>{$satirlar}</tbody></table></div>";
    };

    return '<html><head><title>Dizinler - '.$ad.' - '.$ad.'</title></head><body>'
        .'<div>Her veri tabanından dergilerin dizin güncelliği kontrol edilmelidir.</div>'
        .$tablo('Atıf Dizinleri', $atif)
        .$tablo('Diğer Dizinler', $diger)
        .'</body></html>';
}

/**
 * @param  list<string>  $atif
 * @param  list<string>  $diger
 */
function dergiparkTaklidi(array $atif, array $diger = [], string $slug = 'deneme'): void
{
    Http::fake([
        'doi.org/*' => Http::response('', 302, ['Location' => 'https://dergipark.org.tr/tr/doi/10.1/x']),
        'dergipark.org.tr/tr/doi/*' => Http::response('', 302, ['Location' => "https://dergipark.org.tr/tr/pub/{$slug}/article/1"]),
        'dergipark.org.tr/tr/pub/*/indexes' => Http::response(dizinSayfasi($atif, $diger)),
    ]);
}

function dizinServisi(): DergiParkDizinleri
{
    return new DergiParkDizinleri;
}

function onerici(): KaynakOnerici
{
    return new KaynakOnerici(dizinServisi());
}

/**
 * @param  array<string, mixed>  $meta
 */
function makaleKaydi(User $kullanici, array $meta, ?string $kaynak = null, string $durum = 'beklemede'): Faaliyet
{
    return Faaliyet::factory()->for($kullanici)->create([
        'kategori' => 'makale',
        'kaynak' => $kaynak,
        'durum' => $durum,
        'meta' => $meta,
    ]);
}

// ─────────────────────────── DERGİPARK OKUMA ───────────────────────────

/**
 * doi.org iki adımda varıyor ve kısaltma ancak ikincisinde beliriyor
 * (doi.org → /tr/doi/… → /tr/pub/<slug>/article/…).
 */
test('doi iki yönlendirme sonunda dergi kısaltmasına çözülüyor', function () {
    dergiparkTaklidi(['TR Dizin'], slug: 'nevsosbilen');

    expect(dizinServisi()->slugBul('10.30783/nevsosbilen.1'))->toBe('nevsosbilen');
});

test('dergiparkta olmayan doi kısaltma vermiyor', function () {
    Http::fake([
        'doi.org/*' => Http::response('', 302, ['Location' => 'https://www.nature.com/articles/x']),
        'nature.com/*' => Http::response('', 200),
    ]);

    expect(dizinServisi()->slugBul('10.1038/x'))->toBeNull();
});

test('dizin sayfası atıf ve diğer bölümlerine ayrılıyor', function () {
    dergiparkTaklidi(
        ['Emerging Sources Citation Index (ESCI)', 'TR Dizin'],
        ['SOBIAD', 'EBSCO'],
    );

    $dergi = dizinServisi()->dergi('deneme');

    expect($dergi->ad)->toBe('Deneme Dergisi')
        ->and($dergi->atif_dizinleri)->toBe(['Emerging Sources Citation Index (ESCI)', 'TR Dizin'])
        ->and($dergi->diger_dizinler)->toBe(['SOBIAD', 'EBSCO']);
});

/**
 * Aynı dergide onlarca yayını olan aday aynı sayfayı onlarca kez
 * indirmemeli; kopya bayatlayınca tazeleniyor.
 */
test('taze yerel kopya varken ağa çıkılmıyor, bayat kopya tazeleniyor', function () {
    dergiparkTaklidi(['TR Dizin']);

    dizinServisi()->dergi('deneme');
    dizinServisi()->dergi('deneme');

    Http::assertSentCount(1);

    Dergi::query()->where('slug', 'deneme')->update(['kontrol_edildi_at' => now()->subDays(120)]);
    dizinServisi()->dergi('deneme');

    Http::assertSentCount(2);
});

// ─────────────────────────── ÖNERİ ───────────────────────────

/**
 * Sıra sayfadaki sıra DEĞİL, kademe sırası: dergi hem ESCI hem TR Dizin'de
 * olabilir, önerilecek olan üsttekidir.
 */
test('en üst kademe öneriliyor', function () {
    $kullanici = User::factory()->create();
    dergiparkTaklidi(['TR Dizin', 'Emerging Sources Citation Index (ESCI)']);

    $oneri = onerici()->oner(makaleKaydi($kullanici, ['doi' => '10.1/x']));

    expect($oneri['kaynak'])->toBe('ESCI')
        ->and($oneri['gerekce'])->toContain('Emerging Sources');
});

test('yalnız tr dizindeki dergi tr dizin öneriyor', function () {
    $kullanici = User::factory()->create();
    dergiparkTaklidi(['TR Dizin']);

    expect(onerici()->oner(makaleKaydi($kullanici, ['doi' => '10.1/x']))['kaynak'])->toBe('TR Dizin');
});

/**
 * ÇEYREKLİK ASLA TAHMİN EDİLMİYOR.
 *
 * Sözlükte SCIE/SSCI ve Scopus kademeleri yalnız çeyrekli var (Q1–Q4).
 * Dergi o dizinlerde görünse bile hangi çeyrekte olduğu künyeden
 * çıkarılamıyor; bir çeyreklik uydurmak adayın hak etmediği yönergeyi
 * "uygun" gösterirdi. Öneri yerine uyarı çıkıyor.
 */
test('çeyrekliği bilinmeyen kademede öneri değil uyarı çıkıyor', function (string $dizin, string $ad) {
    // Veri kümesi ŞART, döngü değil: Http::fake() art arda çağrılınca eski
    // taklitler siliniyor değil ekleniyor ve ilk kural kazanıyor — döngüde
    // ikinci tur hâlâ birincinin sayfasını görüyordu.
    $kullanici = User::factory()->create();
    dergiparkTaklidi([$dizin]);

    $oneri = onerici()->oner(makaleKaydi($kullanici, ['doi' => '10.1/x']));

    expect($oneri['kaynak'])->toBeNull()
        ->and($oneri['uyari'])->toContain($ad)
        ->and($oneri['uyari'])->toContain('çeyreklik');
})->with([
    ['Science Citation Index Expanded (SCI-EXPANDED)', 'SCIE'],
    ['Social Sciences Citation Index (SSCI)', 'SSCI'],
    ['Scopus', 'Scopus'],
]);

/**
 * Uzun kuyruk dizinler "Diğer Uluslararası İndeks" mi "Diğer Ulusal
 * Hakemli" mi sayılır — yönergeden yönergeye değişiyor. Tahmin edilmiyor,
 * liste gösterilip karar adaya bırakılıyor.
 */
test('yalnız kuyruk dizinleri varsa öneri yok ama liste veriliyor', function () {
    $kullanici = User::factory()->create();
    dergiparkTaklidi([], ['EBSCO', 'Index Copernicus']);

    $oneri = onerici()->oner(makaleKaydi($kullanici, ['doi' => '10.1/x']));

    expect($oneri['kaynak'])->toBeNull()
        ->and($oneri['uyari'])->toBeNull()
        ->and($oneri['diger'])->toBe(['EBSCO', 'Index Copernicus'])
        ->and($oneri['slug'])->toBe('deneme');
});

/**
 * Adayın kendi seçimi DergiPark'ın listesini yener: kademeyi o onaylamış
 * ve derginin dizin durumu yıllara göre değişmiş olabilir.
 */
test('adayın aynı dergideki önceki seçimi öne geçiyor', function () {
    $kullanici = User::factory()->create();
    dergiparkTaklidi(['TR Dizin']);

    makaleKaydi($kullanici, ['dergi' => 'Deneme Dergisi'], kaynak: 'SCIE/SSCI (Q2)', durum: 'onaylandi');

    $oneri = onerici()->oner(makaleKaydi($kullanici, ['doi' => '10.1/x', 'dergi' => 'Deneme Dergisi']));

    expect($oneri['kaynak'])->toBe('SCIE/SSCI (Q2)')
        ->and($oneri['gerekce'])->toContain('başka yayınınızda');

    // Geçmişten geldiği için ağa hiç çıkılmadı.
    Http::assertNothingSent();
});

test('beklemedeki eski kayıt geçmiş sayılmıyor', function () {
    $kullanici = User::factory()->create();
    dergiparkTaklidi(['TR Dizin']);

    makaleKaydi($kullanici, ['dergi' => 'Deneme Dergisi'], kaynak: 'SCIE/SSCI (Q2)');

    expect(onerici()->oner(makaleKaydi($kullanici, ['doi' => '10.1/x', 'dergi' => 'Deneme Dergisi']))['kaynak'])
        ->toBe('TR Dizin');
});

/**
 * DergiPark'ta olmayan dergi künyeye işaretleniyor: her açılışta yeniden
 * DOI çözmek boşa istek.
 */
test('dergiparkta olmayan dergi bir kez sorulup künyeye yazılıyor', function () {
    $kullanici = User::factory()->create();

    Http::fake([
        'doi.org/*' => Http::response('', 302, ['Location' => 'https://www.nature.com/articles/x']),
        'nature.com/*' => Http::response('', 200),
    ]);

    $faaliyet = makaleKaydi($kullanici, ['doi' => '10.1038/x']);

    onerici()->oner($faaliyet);
    $sayi = count(Http::recorded());

    onerici()->oner($faaliyet->fresh());

    expect($faaliyet->fresh()->meta['dergipark'])->toBeFalse()
        ->and(Http::recorded())->toHaveCount($sayi);
});

// ─────────────────────────── EKRAN ───────────────────────────

test('düzenleme ekranı öneriyi gösteriyor ve tek tıkla uyguluyor', function () {
    $kullanici = User::factory()->create();
    dergiparkTaklidi(['Emerging Sources Citation Index (ESCI)'], ['SOBIAD']);

    $faaliyet = makaleKaydi($kullanici, ['doi' => '10.1/x']);

    Livewire::actingAs($kullanici)->test(FaaliyetEkle::class, ['faaliyet' => $faaliyet])
        ->call('kaynakOner')
        ->assertSee('ESCI')
        ->assertSee('SOBIAD')
        // DergiPark'ın kendi uyarısı da aktarılıyor.
        ->assertSee('dizin güncelliği kontrol edilmelidir')
        ->call('oneriyiUygula')
        ->assertSet('kaynak', 'ESCI');
});

/**
 * Kademesi zaten dolu kayıtta dış servis yoklanmıyor: hem gereksiz istek,
 * hem de adayın seçimini sorgulayan bir kutu.
 */
test('kademesi dolu kayıtta öneri kutusu çizilmiyor', function () {
    $kullanici = User::factory()->create();
    dergiparkTaklidi(['TR Dizin']);

    $faaliyet = makaleKaydi($kullanici, ['doi' => '10.1/x'], kaynak: 'TR Dizin');

    Livewire::actingAs($kullanici)->test(FaaliyetEkle::class, ['faaliyet' => $faaliyet])
        ->assertDontSee('Dergi İndeksi')
        ->assertDontSee('wire:init="kaynakOner"', escape: false);

    Http::assertNothingSent();
});
