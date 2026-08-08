<?php

use App\Enums\TemelAlan;
use App\Models\Yonerge;
use Database\Seeders\EsikSeeder;
use Database\Seeders\YonergeSeeder;

use function Pest\Laravel\seed;

/**
 * @return list<array<int, mixed>>
 */
function esikVerisi(): array
{
    return require database_path('data/esikler.php');
}

test('grup satırları alan başına ayrı satıra açılır', function () {
    $satirlar = esikVerisi();

    // Açılımdan sonra hiçbir satırın alanı dizi kalmamalı.
    foreach ($satirlar as $satir) {
        expect($satir[2])->toBeString();
    }

    // Akdeniz "GRUP 1: Sağlık, Ziraat, Mühendislik, Fen" tek satır yazılır,
    // dört ayrı alana açılır — hepsi aynı barajı taşır.
    $grup1 = collect($satirlar)
        ->filter(fn ($s) => $s[0] === 'Akdeniz Üniversitesi' && $s[1] === 'profesorluk')
        ->filter(fn ($s) => in_array($s[2], ['fen', 'muhendislik', 'saglik', 'ziraat'], true));

    expect($grup1)->toHaveCount(4)
        ->and($grup1->pluck(3)->unique()->all())->toBe([500]);
});

test('veri dosyasındaki alan adları TemelAlan enum değerleridir', function () {
    $gecerli = array_column(TemelAlan::cases(), 'value');

    $gecersiz = collect(esikVerisi())
        ->reject(fn ($s) => in_array($s[2], $gecerli, true))
        ->map(fn ($s) => "{$s[0]}: {$s[2]}")
        ->values()
        ->all();

    expect($gecersiz)->toBe([]);
});

test('aynı üniversite-kadro-alan üçlüsü iki kez tanımlanmaz', function () {
    // EsikSeeder updateOrCreate ile yazdığı için çakışma sessizce son satırı kazandırır.
    $tekrar = collect(esikVerisi())
        ->groupBy(fn ($s) => "{$s[0]} · {$s[1]} · {$s[2]}")
        ->filter(fn ($grup) => $grup->count() > 1)
        ->keys()
        ->all();

    expect($tekrar)->toBe([]);
});

test('grup açılımı veritabanına alan başına ayrı eşik olarak iner', function () {
    seed(YonergeSeeder::class);
    seed(EsikSeeder::class);

    $akdeniz = Yonerge::query()->with('esikler')
        ->whereHas('universite', fn ($q) => $q->where('ad', 'Akdeniz Üniversitesi'))
        ->firstOrFail();

    $baraj = fn (string $kadro, string $alan) => $akdeniz->esikler
        ->first(fn ($e) => $e->kadro === $kadro && $e->alan === $alan)?->min_toplam;

    // Grup 1 üyelerinin hepsi kendi satırına sahip olmalı (fallback yok).
    foreach (['fen', 'muhendislik', 'saglik', 'ziraat'] as $alan) {
        expect($baraj('profesorluk', $alan))->toBe(500);
    }

    // Grup 2 ve Grup 3 aynı barajı taşır ama ayrı satırlardır (alt koşulları farklı).
    expect($baraj('docentlik', 'mimarlik'))->toBe(300)   // Grup 2
        ->and($baraj('docentlik', 'ilahiyat'))->toBe(300) // Grup 3
        // 12 temel alanın tamamı × 3 kadro = 36 satır.
        ->and($akdeniz->esikler)->toHaveCount(36);
});
