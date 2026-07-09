<?php

use App\Enums\Kategori;
use App\Livewire\Yayinlar;
use App\Models\Faaliyet;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->user = User::factory()->onboarded()->create();
    actingAs($this->user);
});

test('faaliyet listesi görüntülenir', function () {
    Faaliyet::factory()->for($this->user)->create(['baslik' => 'Tasavvuf Üzerine']);

    Livewire::test(Yayinlar::class)
        ->assertOk()
        ->assertSee('Tasavvuf Üzerine');
});

test('faaliyet silinir', function () {
    $faaliyet = Faaliyet::factory()->for($this->user)->create();

    Livewire::test(Yayinlar::class)
        ->call('sil', $faaliyet->id);

    expect(Faaliyet::find($faaliyet->id))->toBeNull();
});

test('başka kullanıcının faaliyeti silinemez', function () {
    $baskasi = Faaliyet::factory()->for(User::factory())->create();

    expect(fn () => Livewire::test(Yayinlar::class)->call('sil', $baskasi->id))
        ->toThrow(ModelNotFoundException::class);

    expect($baskasi->fresh())->not->toBeNull();
});

test('kategoriye göre filtreler', function () {
    Faaliyet::factory()->for($this->user)->kategori(Kategori::Makale)->create(['baslik' => 'Makale kaydı']);
    Faaliyet::factory()->for($this->user)->kategori(Kategori::Kitap)->create(['baslik' => 'Kitap kaydı']);

    Livewire::test(Yayinlar::class)
        ->set('kategoriFiltre', Kategori::Kitap->value)
        ->assertSee('Kitap kaydı')
        ->assertDontSee('Makale kaydı');
});
