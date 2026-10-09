<?php

use App\Enums\Plan;
use App\Livewire\Settings\Abonelik as AbonelikSayfasi;
use App\Models\Abonelik;
use App\Models\AbonelikTalebi;
use App\Models\User;
use App\Services\Abonelik\AbonelikTalepleri;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    Mail::fake();
    CarbonImmutable::setTestNow('2026-10-08');

    $this->user = User::factory()->onboarded()->create();
    actingAs($this->user);
});

afterEach(fn () => CarbonImmutable::setTestNow());

test('aboneliği olmayan kullanıcı ücretsiz planda görünür, menülerden sayfaya ulaşılır', function () {
    $this->get(route('dashboard'))->assertSee(route('abonelik'));

    $this->get(route('abonelik'))
        ->assertOk()
        ->assertSee('Mevcut paketiniz')
        ->assertSee('Ücretsiz plan')
        ->assertSee('Paketinizi yükseltin')
        ->assertSee('Henüz bir aboneliğiniz olmadı.');
});

test('aktif abonelik, kalan gün ve geçmiş görünür; yenileme varsayılan seçilir', function () {
    Abonelik::factory()->for($this->user)->create(['plan' => Plan::Kurumsal, 'baslangic' => '2026-10-01', 'bitis' => '2026-10-31', 'tutar_kurus' => 99900]);
    Abonelik::factory()->for($this->user)->bitmis()->create();

    Livewire::test(AbonelikSayfasi::class)
        ->assertSet('paket', 'kurumsal')
        ->assertSee('23 gün kaldı')
        ->assertSee('Yenileme talep et')
        ->assertSee('999,00 ₺')
        ->assertSee('Bitti');
});

test('kullanıcı paket talep eder, talep bekleyen olarak görünür ve geri çekilebilir', function () {
    $bilesen = Livewire::test(AbonelikSayfasi::class)
        ->set('paket', 'akademisyen')
        ->call('talepEt')
        ->assertHasNoErrors()
        ->assertSee('talebiniz inceleniyor')
        ->assertDontSee('Paketinizi yükseltin');

    $talep = AbonelikTalebi::query()->sole();
    expect($talep->plan)->toBe(Plan::Akademisyen)
        ->and($talep->durum)->toBe(AbonelikTalebi::BEKLIYOR);

    $bilesen->call('geriCek')->assertSee('Paketinizi yükseltin');

    expect($talep->refresh()->durum)->toBe(AbonelikTalebi::KAPATILDI)
        ->and($talep->sonuclandiran_id)->toBe($this->user->id);
});

test('ücretsiz paket talep edilemez', function () {
    Livewire::test(AbonelikSayfasi::class)
        ->set('paket', 'ucretsiz')
        ->call('talepEt')
        ->assertHasErrors('paket');

    expect(AbonelikTalebi::query()->count())->toBe(0);
});

test('başkasının talebi geri çekilemez', function () {
    $talep = AbonelikTalebi::factory()->create();

    app(AbonelikTalepleri::class)->geriCek($talep, $this->user);
})->throws(InvalidArgumentException::class);
