<?php

use App\Livewire\Settings\Profile;
use App\Models\User;
use Livewire\Livewire;

test('profile page is displayed', function () {
    $this->actingAs($user = User::factory()->create());

    $this->get('/settings/profile')->assertOk();
});

test('profile information can be updated', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = Livewire::test(Profile::class)
        ->set('name', 'Test User')
        ->set('email', 'test@example.com')
        ->call('updateProfileInformation');

    $response->assertHasNoErrors();

    $user->refresh();

    expect($user->name)->toEqual('Test User');
    expect($user->email)->toEqual('test@example.com');
    expect($user->email_verified_at)->toBeNull();
});

test('akademik bilgiler güncellenebilir ve fakülte kaskadı çalışır', function () {
    $user = User::factory()->onboarded()->create();

    $this->actingAs($user);

    Livewire::test(Profile::class)
        ->assertSet('temelAlan', 'ilahiyat')
        ->assertSet('fakulte', 'İlahiyat Fakültesi')
        ->set('temelAlan', 'saglik')            // İlahiyat sağlıkta yok → sıfırlanır
        ->assertSet('fakulte', '')
        ->set('fakulte', 'Tıp Fakültesi')
        ->set('bolum', 'Cerrahi Tıp Bilimleri')
        ->set('universite', 'Hacettepe Üniversitesi')
        ->call('updateProfileInformation')
        ->assertHasNoErrors();

    $user->refresh();

    expect($user->universite)->toBe('Hacettepe Üniversitesi')
        ->and($user->temel_alan->value)->toBe('saglik')
        ->and($user->fakulte)->toBe('Tıp Fakültesi')
        ->and($user->bolum)->toBe('Cerrahi Tıp Bilimleri');
});

test('email verification status is unchanged when email address is unchanged', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = Livewire::test(Profile::class)
        ->set('name', 'Test User')
        ->set('email', $user->email)
        ->call('updateProfileInformation');

    $response->assertHasNoErrors();

    expect($user->refresh()->email_verified_at)->not->toBeNull();
});

test('user can delete their account', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = Livewire::test('settings.delete-user-form')
        ->set('password', 'password')
        ->call('deleteUser');

    $response
        ->assertHasNoErrors()
        ->assertRedirect('/');

    expect($user->fresh())->toBeNull();
    expect(auth()->check())->toBeFalse();
});

test('correct password must be provided to delete account', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = Livewire::test('settings.delete-user-form')
        ->set('password', 'wrong-password')
        ->call('deleteUser');

    $response->assertHasErrors(['password']);

    expect($user->fresh())->not->toBeNull();
});

test('akademik profil alanları kaydedilir ve şart ağacı profiline yansır', function () {
    $user = User::factory()->onboarded()->create();

    $this->actingAs($user);

    Livewire::test(Profile::class)
        ->set('akademik.program_dili', 'yabanci_dil_100')
        ->set('akademik.doktora_tarihi', '2019-06-15')
        ->set('akademik.docentlik_tarihi', '2024-03-01')
        ->set('akademik.yds_puani', '85')
        ->set('akademik.h_indeksi', '7')
        ->set('akademik.yurtdisi_ay', '6')
        ->call('updateProfileInformation')
        ->assertHasNoErrors();

    $user->refresh();

    expect($user->program_dili)->toBe('yabanci_dil_100')
        ->and($user->doktora_tarihi->toDateString())->toBe('2019-06-15')
        ->and($user->yds_puani)->toBe(85)
        ->and($user->h_indeksi)->toBe(7);

    // Motorun okuduğu profil nesnesine geçiyor mu?
    $profil = $user->sartProfili([]);

    expect($profil->yds)->toBe(85)
        ->and($profil->hIndeksi)->toBe(7)
        ->and($profil->yurtdisiAy)->toBe(6)
        ->and($profil->programDili)->toBe('yabanci_dil_100')
        ->and($profil->referansTarih('doktora')->toDateString())->toBe('2019-06-15')
        ->and($profil->referansTarih('son_atama'))->toBeNull();
});

test('boş bırakılan akademik alan null kalır (0 ile karıştırılmaz)', function () {
    // "0" kesin olumsuz, null belirsiz: motor bu ikisini farklı değerlendiriyor.
    $user = User::factory()->onboarded()->create(['h_indeksi' => 5]);

    $this->actingAs($user);

    Livewire::test(Profile::class)
        ->assertSet('akademik.h_indeksi', '5')
        ->set('akademik.h_indeksi', '')
        ->set('akademik.yurtdisi_ay', '0')
        ->call('updateProfileInformation')
        ->assertHasNoErrors();

    $user->refresh();

    expect($user->h_indeksi)->toBeNull()
        ->and($user->yurtdisi_ay)->toBe(0)
        ->and($user->sartProfili([])->hIndeksi)->toBeNull()
        ->and($user->sartProfili([])->yurtdisiAy)->toBe(0);
});

test('geçersiz akademik değer doğrulamaya takılır', function () {
    $user = User::factory()->onboarded()->create();

    $this->actingAs($user);

    Livewire::test(Profile::class)
        ->set('akademik.doktora_tarihi', now()->addYear()->toDateString())
        ->set('akademik.h_indeksi', '-3')
        ->set('akademik.program_dili', 'klingonca')
        ->call('updateProfileInformation')
        ->assertHasErrors(['akademik.doktora_tarihi', 'akademik.h_indeksi', 'akademik.program_dili']);
});
