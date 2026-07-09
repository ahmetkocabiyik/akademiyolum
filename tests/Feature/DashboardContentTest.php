<?php

use App\Enums\Kategori;
use App\Livewire\Dashboard;
use App\Models\Faaliyet;
use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

test('dashboard toplam puanı ve faaliyetleri gösterir', function () {
    $user = User::factory()->onboarded()->create();

    Faaliyet::factory()->for($user)->create([
        'kategori' => Kategori::Makale,
        'baslik' => 'Tasavvufi Düşüncenin Öncüleri',
        'puan' => 10,
        'durum' => 'onaylandi',
    ]);
    Faaliyet::factory()->for($user)->kategori(Kategori::TezYayini)->create([
        'puan' => 5,
        'durum' => 'onaylandi',
    ]);

    actingAs($user);

    Livewire::test(Dashboard::class)
        ->assertOk()
        ->assertSee('Tasavvufi Düşüncenin Öncüleri')
        ->assertSee('Kategori Puan Dağılımı');
});

test('sadece onaylı faaliyetler puana katılır', function () {
    $user = User::factory()->onboarded()->create();

    Faaliyet::factory()->for($user)->create(['puan' => 10, 'durum' => 'onaylandi']);
    Faaliyet::factory()->for($user)->beklemede()->create(['puan' => 99]);

    actingAs($user);

    $rapor = Livewire::test(Dashboard::class)->instance()->rapor();

    expect($rapor->toplamPuan)->toBe(10);
});

test('boş dashboard eksik faaliyet bildirimi gösterir', function () {
    actingAs(User::factory()->onboarded()->create());

    Livewire::test(Dashboard::class)
        ->assertOk()
        ->assertSee('Toplumsal Katkı eklenmemiş')
        ->assertSee('Henüz faaliyet eklenmemiş.');
});
