<?php

use App\Enums\Kategori;
use App\Livewire\Faaliyetler;
use App\Models\Faaliyet;
use App\Models\Universite;
use App\Models\User;
use App\Services\Scoring\Sart\SartDeposu;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->user = User::factory()->onboarded()->create();
    actingAs($this->user);
});

test('faaliyet listesi görüntülenir', function () {
    Faaliyet::factory()->for($this->user)->create(['baslik' => 'Tasavvuf Üzerine']);

    Livewire::test(Faaliyetler::class)
        ->assertOk()
        ->assertSee('Tasavvuf Üzerine');
});

test('faaliyet silinir', function () {
    $faaliyet = Faaliyet::factory()->for($this->user)->create();

    Livewire::test(Faaliyetler::class)
        ->call('sil', $faaliyet->id);

    expect(Faaliyet::find($faaliyet->id))->toBeNull();
});

test('başka kullanıcının faaliyeti silinemez', function () {
    $baskasi = Faaliyet::factory()->for(User::factory())->create();

    expect(fn () => Livewire::test(Faaliyetler::class)->call('sil', $baskasi->id))
        ->toThrow(ModelNotFoundException::class);

    expect($baskasi->fresh())->not->toBeNull();
});

test('kategoriye göre filtreler', function () {
    Faaliyet::factory()->for($this->user)->kategori(Kategori::Makale)->create(['baslik' => 'Makale kaydı']);
    Faaliyet::factory()->for($this->user)->kategori(Kategori::Kitap)->create(['baslik' => 'Kitap kaydı']);

    Livewire::test(Faaliyetler::class)
        ->set('kategoriFiltre', Kategori::Kitap->value)
        ->assertSee('Kitap kaydı')
        ->assertDontSee('Makale kaydı');
});

test('toplumsal katkı artık ayrı bölüm değil, faaliyetlere yönlendirir', function () {
    // Bölüm kaldırıldı: Toplumsal Katkı, Faaliyetler içinde bir kategori.
    actingAs(User::factory()->onboarded()->create())
        ->get('/toplumsal-katki')
        ->assertRedirect('/faaliyetler');
});

test('navigasyonda Toplumsal Katkı bağlantısı yok', function () {
    actingAs(User::factory()->onboarded()->create())
        ->get(route('faaliyetler'))
        ->assertOk()
        ->assertSee('Faaliyetler')
        ->assertDontSee('href="'.url('/toplumsal-katki').'"', false);
});

test('listedeki satır faaliyetin düzenleme sayfasına bağlanır', function () {
    $faaliyet = Faaliyet::factory()->for($this->user)->create(['baslik' => 'Tıklanabilir Satır']);

    Livewire::test(Faaliyetler::class)
        ->assertOk()
        // Başlık gerçek bir bağlantı: klavye ve ekran okuyucu erişimi korunur.
        ->assertSeeHtml('href="'.route('faaliyetler.duzenle', $faaliyet).'"')
        // Satır tıklaması o bağlantıyı tetikler, işlem düğmeleri hariç tutulur.
        ->assertSeeHtml("closest('a, button') || \$refs.duzenle.click()");
});

test('listedeki puan kendi üniversitesinin cetvelinden hesaplanır', function () {
    Universite::factory()->create(['ad' => 'Test Üniversitesi']);
    app()->instance(SartDeposu::class, new SartDeposu(
        esikVerisi: [[
            'anahtar' => 'test-dr-ilahiyat', 'universite' => 'Test Üniversitesi',
            'kadro' => 'dr_ogr_uyesi', 'alan' => 'ilahiyat', 'birim' => null,
            'cetvel' => 'test-cetvel', 'notlar' => '',
            'sart' => ['tip' => 'puan', 'rol' => 'toplam', 'aciklama' => 'Toplam',
                'maddeler' => ['*'], 'min_puan' => 50],
        ]],
        cetvelVerisi: ['test-cetvel' => ['maddeler' => [
            'M1' => ['baslik' => 'TR Dizin makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'puan' => 10],
        ]]],
    ));
    $this->user->update(['universite' => 'Test Üniversitesi', 'unvan' => 'Arş. Gör.']);

    // Puan saklanmıyor; sütundaki değer gösterilmemeli.
    Faaliyet::factory()->for($this->user)->create(['kaynak' => 'TR Dizin', 'durum' => 'onaylandi', 'puan' => 0]);

    Livewire::test(Faaliyetler::class)
        ->assertSeeHtml('data-faaliyet-puani>10</td>')
        ->assertDontSeeHtml('data-faaliyet-puani>0</td>');
});

test('onay anahtarı faaliyeti onaylandı ile beklemede arasında değiştirir', function () {
    $faaliyet = Faaliyet::factory()->for($this->user)->create(['durum' => 'onaylandi']);

    $bilesen = Livewire::test(Faaliyetler::class)
        ->assertSeeHtml('data-onay-anahtari="'.$faaliyet->id.'"')
        ->call('durumDegistir', $faaliyet->id);

    expect($faaliyet->refresh()->durum)->toBe('beklemede');

    $bilesen->call('durumDegistir', $faaliyet->id);

    expect($faaliyet->refresh()->durum)->toBe('onaylandi');
});

test('başka kullanıcının faaliyetinin durumu değiştirilemez', function () {
    $baskasi = Faaliyet::factory()->create(['durum' => 'beklemede']);

    expect(fn () => Livewire::test(Faaliyetler::class)->call('durumDegistir', $baskasi->id))
        ->toThrow(ModelNotFoundException::class);

    expect($baskasi->refresh()->durum)->toBe('beklemede');
});
