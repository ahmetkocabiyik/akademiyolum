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
        ->set('yazarlar', ['Ahmet K.', 'Mehmet Y.'])
        ->set('kaynak', 'SCI/SSCI')
        ->set('yil', '2025')
        ->call('kaydet')
        ->assertHasNoErrors()
        ->assertRedirect(route('yayinlar'));

    $faaliyet = $this->user->faaliyetler()->sole();

    expect($faaliyet->baslik)->toBe('Kelam İlminde Yöntem')
        ->and($faaliyet->kategori)->toBe(Kategori::Makale)
        ->and($faaliyet->tur)->toBe('Makale') // tür kategori etiketinden türetilir
        ->and($faaliyet->yazarlar)->toBe('Ahmet K., Mehmet Y.')
        ->and($faaliyet->puan)->toBe(20)
        ->and($faaliyet->durum)->toBe('onaylandi')
        ->and($faaliyet->meta['yil'])->toBe('2025');
});

test('yazar eklenip silinebilir ve kaydederken birleştirilir', function () {
    Livewire::test(YayinEkle::class)
        ->assertSet('yazarlar', [''])
        ->call('yazarEkle')
        ->call('yazarEkle')
        ->assertCount('yazarlar', 3)
        ->set('yazarlar.0', 'Yazar Bir')
        ->set('yazarlar.1', 'Yazar İki')
        ->call('yazarSil', 1)
        ->assertCount('yazarlar', 2)
        ->set('kategori', Kategori::Makale->value)
        ->set('baslik', 'Çok Yazarlı Makale')
        ->call('kaydet')
        ->assertHasNoErrors();

    expect($this->user->faaliyetler()->sole()->yazarlar)->toBe('Yazar Bir');
});

test('düzenlemede yazarlar diziye ayrıştırılır', function () {
    $faaliyet = Faaliyet::factory()->for($this->user)->create(['yazarlar' => 'Ali V., Veli A.']);

    Livewire::test(YayinEkle::class, ['faaliyet' => $faaliyet])
        ->assertSet('yazarlar', ['Ali V.', 'Veli A.']);
});

test('hızlı-ekle kategori query parametresi ön-seçili gelir', function () {
    Livewire::withQueryParams(['kategori' => 'tez_yayini'])
        ->test(YayinEkle::class)
        ->assertSet('kategori', 'tez_yayini');
});

test('geçersiz kategori query parametresi varsayılanı korur', function () {
    Livewire::withQueryParams(['kategori' => 'olmayan'])
        ->test(YayinEkle::class)
        ->assertSet('kategori', 'makale');
});

test('kategori değişince kaynak sıfırlanır', function () {
    Livewire::test(YayinEkle::class)
        ->set('kaynak', 'SCI/SSCI')
        ->set('kategori', Kategori::Kitap->value)
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
        ->call('kaydet')
        ->assertHasErrors(['baslik']);

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
