<?php

use App\Livewire\Onboarding;
use App\Models\User;
use App\Models\Yonerge;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

test('fakülte seçenekleri temel alana göre gelir', function () {
    actingAs(User::factory()->create());

    Livewire::test(Onboarding::class)
        ->set('step', 2)
        ->set('temelAlan', 'saglik')
        ->assertSee('Tıp Fakültesi')
        ->assertDontSee('İlahiyat Fakültesi');
});

test('temel alan değişince listede olmayan fakülte sıfırlanır', function () {
    actingAs(User::factory()->create());

    Livewire::test(Onboarding::class)
        ->set('temelAlan', 'ilahiyat')
        ->set('fakulte', 'İlahiyat Fakültesi')
        ->set('temelAlan', 'saglik')            // İlahiyat sağlıkta yok
        ->assertSet('fakulte', '');
});

test('bölüm seçenekleri fakülteye göre gelir ve fakülte değişince sıfırlanır', function () {
    actingAs(User::factory()->create());

    Livewire::test(Onboarding::class)
        ->set('step', 2)
        ->set('temelAlan', 'saglik')
        ->set('fakulte', 'Tıp Fakültesi')
        ->assertSee('Cerrahi Tıp Bilimleri')     // Tıp bölümleri gelir
        ->set('bolum', 'Cerrahi Tıp Bilimleri')
        ->set('fakulte', 'Diş Hekimliği Fakültesi')  // fakülte değişti
        ->assertSet('bolum', '');                // eski bölüm yeni fakültede yok → sıfırlandı
});

test('fakülte ve bölüm opsiyonel — boş bırakılabilir', function () {
    $yonerge = Yonerge::factory()->create();
    $user = User::factory()->create();
    actingAs($user);

    Livewire::test(Onboarding::class)
        ->set('name', 'Boş Alan Hoca')
        ->set('unvan', 'Dr. Öğr. Üyesi')
        ->call('next')
        ->assertSet('step', 2)
        ->set('universite', 'Mersin Üniversitesi')
        ->set('temelAlan', 'sosyal')
        ->call('submit')
        ->assertHasNoErrors();

    $user->refresh();
    expect($user->fakulte)->toBeNull()
        ->and($user->bolum)->toBeNull()
        ->and($user->yonerge_id)->toBe($yonerge->id)   // varsayılan ÜAK genel atanır
        ->and($user->hasCompletedOnboarding())->toBeTrue();
});

test('onboarded user reaches the dashboard', function () {
    actingAs(User::factory()->onboarded()->create())
        ->get(route('dashboard'))
        ->assertOk();
});

test('user without onboarding is redirected from dashboard to onboarding', function () {
    actingAs(User::factory()->create())
        ->get(route('dashboard'))
        ->assertRedirect(route('onboarding'));
});

test('module routes are gated behind onboarding', function () {
    actingAs(User::factory()->create())
        ->get(route('yonerge-analizi'))
        ->assertRedirect(route('onboarding'));
});

test('onboarded user can load a module placeholder page', function () {
    actingAs(User::factory()->onboarded()->create())
        ->get(route('faaliyetler'))
        ->assertOk()
        ->assertSee('Faaliyetler');
});

test('onboarding flow saves profile and completes', function () {
    $yonerge = Yonerge::factory()->create(['ad' => 'ÜAK Doçentlik — İlahiyat 2026']);
    $user = User::factory()->create(['name' => 'Test Hoca']);

    actingAs($user);

    Livewire::test(Onboarding::class)
        ->set('name', 'Prof. Test')
        ->set('unvan', 'Doç. Dr.')
        ->call('next')
        ->assertSet('step', 2)
        ->set('universite', 'Mersin Üniversitesi')
        ->set('temelAlan', 'ilahiyat')
        ->set('fakulte', 'İlahiyat Fakültesi')
        ->set('bolum', 'Temel İslam Bilimleri')
        ->call('submit')
        ->assertRedirect(route('dashboard'));

    $user->refresh();

    expect($user->hasCompletedOnboarding())->toBeTrue()
        ->and($user->unvan)->toBe('Doç. Dr.')
        ->and($user->universite)->toBe('Mersin Üniversitesi')
        ->and($user->bolum)->toBe('Temel İslam Bilimleri')
        ->and($user->temel_alan->value)->toBe('ilahiyat')
        ->and($user->yonerge_id)->toBe($yonerge->id)
        ->and($user->yonerge)->toBe('ÜAK Doçentlik — İlahiyat 2026');
});

test('onboarding validates required fields before advancing', function () {
    actingAs(User::factory()->create());

    Livewire::test(Onboarding::class)
        ->set('name', '')
        ->call('next')
        ->assertHasErrors(['name' => 'required'])
        ->assertSet('step', 1);
});

test('onboarding ekranından çıkış yapılabilir', function () {
    actingAs(User::factory()->create());

    Livewire::test(Onboarding::class)
        ->call('cikis')
        ->assertRedirect(route('login'));

    expect(auth()->check())->toBeFalse();
});

test('already onboarded user visiting onboarding is redirected to dashboard', function () {
    actingAs(User::factory()->onboarded()->create());

    Livewire::test(Onboarding::class)
        ->assertRedirect(route('dashboard'));
});
