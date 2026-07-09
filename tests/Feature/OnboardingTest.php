<?php

use App\Livewire\Onboarding;
use App\Models\User;
use App\Models\Yonerge;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

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
        ->get(route('yayinlar'))
        ->assertOk()
        ->assertSee('Yayınlar');
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
        ->set('fakulte', 'İlahiyat Fakültesi')
        ->set('alan', 'Kelam')
        ->call('next')
        ->assertSet('step', 3)
        ->set('yonergeId', (string) $yonerge->id)
        ->call('submit')
        ->assertRedirect(route('dashboard'));

    $user->refresh();

    expect($user->hasCompletedOnboarding())->toBeTrue()
        ->and($user->unvan)->toBe('Doç. Dr.')
        ->and($user->universite)->toBe('Mersin Üniversitesi')
        ->and($user->alan)->toBe('Kelam')
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

test('already onboarded user visiting onboarding is redirected to dashboard', function () {
    actingAs(User::factory()->onboarded()->create());

    Livewire::test(Onboarding::class)
        ->assertRedirect(route('dashboard'));
});
