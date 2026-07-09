<?php

use App\Models\User;

use function Pest\Laravel\actingAs;

test('landing page pazarlama içeriğini gösterir', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertSee('Kontrol Merkezi')
        ->assertSee('Akademik kariyer yönetiminin tüm araçları')
        ->assertSee('₺299');
});

test('misafir kullanıcı giriş ve kayıt bağlantılarını görür', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertSee(route('login'))
        ->assertSee(route('register'))
        ->assertSee('Giriş Yap')
        ->assertSee('Ücretsiz Başla');
});

test('giriş yapmış kullanıcı panele git bağlantısını görür', function () {
    actingAs(User::factory()->onboarded()->create())
        ->get(route('home'))
        ->assertOk()
        ->assertSee(route('dashboard'))
        ->assertSee('Panele Git')
        ->assertDontSee('Giriş Yap');
});
