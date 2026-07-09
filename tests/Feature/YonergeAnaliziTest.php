<?php

use App\Enums\Kategori;
use App\Livewire\YonergeAnalizi;
use App\Models\Faaliyet;
use App\Models\User;
use Database\Seeders\YonergeSeeder;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->seed(YonergeSeeder::class);

    $this->user = User::factory()->onboarded()->create();

    // Toplam 70 puan: makale 40 (tavan), kitap 20, tez 10.
    Faaliyet::factory()->for($this->user)->create(['kategori' => Kategori::Makale, 'kaynak' => 'SCI/SSCI', 'puan' => 20]);
    Faaliyet::factory()->for($this->user)->create(['kategori' => Kategori::Makale, 'kaynak' => 'SCI/SSCI', 'puan' => 20]);
    Faaliyet::factory()->for($this->user)->create(['kategori' => Kategori::Kitap, 'kaynak' => 'Uluslararası Yayınevi', 'puan' => 20]);
    Faaliyet::factory()->for($this->user)->create(['kategori' => Kategori::TezYayini, 'kaynak' => 'SCI/SSCI', 'puan' => 10]);

    actingAs($this->user);
});

test('tüm üniversite yönergelerini listeler', function () {
    $sonuclar = Livewire::test(YonergeAnalizi::class)->instance()->sonuclar();

    expect($sonuclar)->toHaveCount(6);
});

test('barajı karşılayan yönerge yapılabilir işaretlenir', function () {
    $sonuclar = collect(Livewire::test(YonergeAnalizi::class)->instance()->sonuclar())
        ->keyBy(fn ($s) => $s['yonerge']->universite->ad);

    // İstanbul 29 Mayıs barajı 55 → 70 puan yeterli.
    $istanbul = $sonuclar['İstanbul 29 Mayıs Üniversitesi'];
    expect($istanbul['toplam'])->toBe(70)
        ->and($istanbul['yapilabilir'])->toBeTrue()
        ->and($istanbul['kalan'])->toBe(0);

    // Ankara barajı 120 → 50 puan eksik.
    $ankara = $sonuclar['Ankara Üniversitesi'];
    expect($ankara['yapilabilir'])->toBeFalse()
        ->and($ankara['kalan'])->toBe(50);
});

test('üniversite türüne göre filtreler', function () {
    $sonuclar = Livewire::test(YonergeAnalizi::class)
        ->set('turFiltre', 'vakif')
        ->instance()->sonuclar();

    expect($sonuclar)->toHaveCount(1)
        ->and($sonuclar[0]['yonerge']->universite->ad)->toBe('İstanbul 29 Mayıs Üniversitesi');
});

test('kadroya göre filtreler', function () {
    $sonuclar = Livewire::test(YonergeAnalizi::class)
        ->set('kadroFiltre', 'dr_ogr_uyesi')
        ->instance()->sonuclar();

    expect($sonuclar)->toHaveCount(2);
});

test('baraja göre artan sıralar', function () {
    $sonuclar = Livewire::test(YonergeAnalizi::class)
        ->set('siralama', 'baraj_artan')
        ->instance()->sonuclar();

    $barajlar = array_column($sonuclar, 'baraj');

    expect($barajlar)->toBe([55, 60, 80, 90, 100, 120]);
});

test('profil toplamı kullanıcının kendi puanını yansıtır', function () {
    expect(Livewire::test(YonergeAnalizi::class)->instance()->profilToplam())->toBe(70);
});

test('sayfa render olur ve üniversiteleri gösterir', function () {
    Livewire::test(YonergeAnalizi::class)
        ->assertOk()
        ->assertSee('Mersin Üniversitesi')
        ->assertSee('Mevcut Profilim');
});
