<?php

use App\Enums\Kategori;
use App\Livewire\Dashboard;
use App\Models\Faaliyet;
use App\Models\Universite;
use App\Models\User;
use App\Services\Scoring\Sart\SartDeposu;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

/**
 * Dashboard artık Yönerge Analizi ile AYNI motoru kullanıyor: kullanıcının
 * kendi üniversitesinin şart ağacı değerlendirilir. Yönergesi girilmemiş
 * kullanıcıya tahmini puan gösterilmez.
 */
function dashboardDeposu(int $baraj = 50): SartDeposu
{
    return new SartDeposu(
        esikVerisi: [[
            'anahtar' => 'test-dr-ilahiyat',
            'universite' => 'Test Üniversitesi',
            'kadro' => 'dr_ogr_uyesi',
            'alan' => 'ilahiyat',
            'birim' => null,
            'cetvel' => 'test-cetvel',
            'notlar' => '',
            'sart' => ['tip' => 've', 'aciklama' => 'Asgari şartlar', 'cocuklar' => [
                ['tip' => 'puan', 'rol' => 'toplam', 'aciklama' => "Toplam en az {$baraj} puan",
                    'maddeler' => ['*'], 'min_puan' => $baraj],
            ]],
        ]],
        cetvelVerisi: ['test-cetvel' => ['maddeler' => [
            'M1' => ['baslik' => 'TR Dizin makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'puan' => 10],
            'T1' => ['baslik' => 'Tez yayını', 'kategori' => 'tez_yayini', 'puan' => 5],
        ]]],
    );
}

test('dashboard faaliyetleri ve kategori dağılımını gösterir', function () {
    Universite::factory()->create(['ad' => 'Test Üniversitesi']);
    app()->instance(SartDeposu::class, dashboardDeposu());

    $user = User::factory()->onboarded()->create(['universite' => 'Test Üniversitesi', 'unvan' => 'Arş. Gör.']);

    Faaliyet::factory()->for($user)->create([
        'kategori' => Kategori::Makale,
        'baslik' => 'Tasavvufi Düşüncenin Öncüleri',
        'kaynak' => 'TR Dizin',
        'durum' => 'onaylandi',
    ]);
    Faaliyet::factory()->for($user)->kategori(Kategori::TezYayini)->create(['durum' => 'onaylandi']);

    actingAs($user);

    Livewire::test(Dashboard::class)
        ->assertOk()
        ->assertSee('Tasavvufi Düşüncenin Öncüleri')
        ->assertSee('Kategori Puan Dağılımı');
});

test('sadece onaylı faaliyetler puana katılır', function () {
    Universite::factory()->create(['ad' => 'Test Üniversitesi']);
    app()->instance(SartDeposu::class, dashboardDeposu());

    $user = User::factory()->onboarded()->create(['universite' => 'Test Üniversitesi', 'unvan' => 'Arş. Gör.']);

    Faaliyet::factory()->for($user)->create(['kaynak' => 'TR Dizin', 'durum' => 'onaylandi']);
    Faaliyet::factory()->for($user)->beklemede()->create(['kaynak' => 'TR Dizin']);

    actingAs($user);

    // Onaylı tek makale → M1 = 10 puan. Bekleyen sayılmaz.
    expect(Livewire::test(Dashboard::class)->instance()->toplam())->toBe(10);
});

test('puan faaliyette saklanmaz, kendi üniversitesinin cetvelinden hesaplanır', function () {
    Universite::factory()->create(['ad' => 'Test Üniversitesi']);
    app()->instance(SartDeposu::class, dashboardDeposu());

    $user = User::factory()->onboarded()->create(['universite' => 'Test Üniversitesi', 'unvan' => 'Arş. Gör.']);

    // puan sütunu kasten yanlış: motor cetvelden hesaplamalı.
    Faaliyet::factory()->for($user)->create([
        'kaynak' => 'TR Dizin', 'durum' => 'onaylandi', 'puan' => 9999,
    ]);

    actingAs($user);

    expect(Livewire::test(Dashboard::class)->instance()->toplam())->toBe(10);
});

test('yönergesi girilmemiş üniversitede puan gösterilmez', function () {
    Universite::factory()->create(['ad' => 'Verisi Olmayan Üni']);
    app()->instance(SartDeposu::class, dashboardDeposu());

    $user = User::factory()->onboarded()->create(['universite' => 'Verisi Olmayan Üni', 'unvan' => 'Arş. Gör.']);
    Faaliyet::factory()->for($user)->create(['kaynak' => 'TR Dizin', 'durum' => 'onaylandi']);

    actingAs($user);

    $bilesen = Livewire::test(Dashboard::class);

    expect($bilesen->instance()->esik())->toBeNull()
        ->and($bilesen->instance()->baraj())->toBeNull()
        // Tahmini baraj üretilmez, kullanıcıya durum açıkça söylenir.
        ->and($bilesen->instance()->toplam())->toBe(0);

    $bilesen->assertSee('yönergesi henüz girilmedi');
});

test('bildirimler eşik sonucundan türer', function () {
    Universite::factory()->create(['ad' => 'Test Üniversitesi']);
    app()->instance(SartDeposu::class, dashboardDeposu(baraj: 100));

    $user = User::factory()->onboarded()->create(['universite' => 'Test Üniversitesi', 'unvan' => 'Arş. Gör.']);
    Faaliyet::factory()->for($user)->create(['kaynak' => 'TR Dizin', 'durum' => 'onaylandi']);

    actingAs($user);

    $bildirimler = Livewire::test(Dashboard::class)->instance()->bildirimler();
    $basliklar = array_column($bildirimler, 'baslik');

    // 10/100 → hem karşılanmayan koşul hem kalan puan bildirimi
    expect($basliklar)->toContain('Toplam en az 100 puan')
        ->and(implode(' ', $basliklar))->toContain('90 puan kaldı');
});

test('boş dashboard faaliyet uyarısı gösterir', function () {
    app()->instance(SartDeposu::class, dashboardDeposu());
    actingAs(User::factory()->onboarded()->create(['universite' => 'Verisi Olmayan Üni', 'unvan' => 'Arş. Gör.']));

    Livewire::test(Dashboard::class)
        ->assertOk()
        ->assertSee('Henüz faaliyet eklenmemiş.');
});
