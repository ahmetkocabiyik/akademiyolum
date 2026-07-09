<?php

use App\Enums\Kategori;
use App\Livewire\YayinEkle;
use App\Models\Faaliyet;
use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->user = User::factory()->onboarded()->create();
    actingAs($this->user);
});

test('ekleme sayfası ayrı bir sayfa olarak açılır', function () {
    $this->get(route('yayinlar.ekle'))
        ->assertOk()
        ->assertSee('Yayın Ekle')
        ->assertSee('Manuel Ekle')
        ->assertSee("AVESİS'ten Çek");
});

test('manuel yayın ekler ve puanı kaynaktan hesaplar', function () {
    Livewire::test(YayinEkle::class)
        ->set('kategori', Kategori::Makale->value)
        ->set('baslik', 'Kelam İlminde Yöntem')
        ->set('tur', 'Dergi Makalesi')
        ->set('kaynak', 'SCI/SSCI')
        ->set('yil', '2025')
        ->call('kaydet')
        ->assertHasNoErrors()
        ->assertRedirect(route('yayinlar'));

    $faaliyet = $this->user->faaliyetler()->sole();

    expect($faaliyet->baslik)->toBe('Kelam İlminde Yöntem')
        ->and($faaliyet->kategori)->toBe(Kategori::Makale)
        ->and($faaliyet->puan)->toBe(20)
        ->and($faaliyet->durum)->toBe('onaylandi')
        ->and($faaliyet->meta['yil'])->toBe('2025');
});

test('kategori değişince tür etiketi ve kaynak güncellenir', function () {
    Livewire::test(YayinEkle::class)
        ->set('kaynak', 'SCI/SSCI')
        ->set('kategori', Kategori::Kitap->value)
        ->assertSet('tur', 'Kitap')
        ->assertSet('kaynak', '');
});

test('canlı tahmini puan kaynağa göre hesaplanır', function () {
    $component = Livewire::test(YayinEkle::class)
        ->set('kategori', Kategori::Makale->value)
        ->set('kaynak', 'TR Dizin');

    expect($component->instance()->tahminiPuan())->toBe(10);
});

test('zorunlu alanlar doğrulanır', function () {
    Livewire::test(YayinEkle::class)
        ->set('baslik', '')
        ->set('tur', '')
        ->call('kaydet')
        ->assertHasErrors(['baslik', 'tur']);

    expect($this->user->faaliyetler()->count())->toBe(0);
});

test('mevcut faaliyet düzenlenir ve puan yeniden hesaplanır', function () {
    $faaliyet = Faaliyet::factory()->for($this->user)->create([
        'kategori' => Kategori::Makale,
        'kaynak' => 'TR Dizin',
        'puan' => 10,
    ]);

    Livewire::test(YayinEkle::class, ['faaliyet' => $faaliyet])
        ->assertSet('baslik', $faaliyet->baslik)
        ->set('kaynak', 'SCI/SSCI')
        ->call('kaydet')
        ->assertHasNoErrors();

    expect($faaliyet->refresh()->puan)->toBe(20);
});

test('başka kullanıcının faaliyeti düzenlenemez', function () {
    $baskasi = Faaliyet::factory()->for(User::factory())->create();

    $this->get(route('yayinlar.duzenle', $baskasi))->assertNotFound();
});
