<?php

use App\Enums\Kategori;
use App\Livewire\CvOlusturucu;
use App\Livewire\FaaliyetEkle;
use App\Livewire\Faaliyetler;
use App\Livewire\Onboarding;
use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

/*
 * Arayüz hareketlerinin SUNUCU tarafı: hangi elemanın vurgulanacağı, hangi
 * olayın yayınlanacağı, geçişin yönü. Animasyonun kendisi tarayıcıda.
 */

test('eklenen faaliyet listede vurgulanır, diğerleri vurgulanmaz', function () {
    $user = User::factory()->onboarded()->create();
    $eski = $user->faaliyetler()->create(['kategori' => 'makale', 'tur' => 'Makale', 'baslik' => 'Eski makale', 'durum' => 'onaylandi']);
    actingAs($user);

    Livewire::test(FaaliyetEkle::class)
        ->set('kategori', Kategori::Makale->value)
        ->set('baslik', 'Yeni makale')
        ->call('kaydet')
        ->assertHasNoErrors();

    $yeni = $user->faaliyetler()->where('baslik', 'Yeni makale')->sole();
    expect(session(Faaliyetler::VURGULANAN))->toBe([$yeni->id]);

    $html = Livewire::test(Faaliyetler::class)->html();
    expect(substr_count($html, 'data-vurgu'))->toBe(1)
        ->and($html)->toMatch('/data-vurgu[^>]*>\s*<td[^>]*>\s*<a[^>]*>Yeni makale/');

    // Silme, satır kayarak çıktıktan SONRA gönderiliyor.
    expect($html)->toContain("cikis(\$el.closest('tr')).then(() => \$wire.sil({$eski->id}))");
});

test('cv alanı değişince kaydedildi olayı yayınlanır', function () {
    actingAs(User::factory()->onboarded()->create());

    Livewire::test(CvOlusturucu::class)
        ->set('telefon', '0532 000 00 00')
        ->assertDispatched('cv-kaydedildi');
});

test('onboarding adımı geçiş yönünü taşır', function () {
    actingAs(User::factory()->create());

    Livewire::test(Onboarding::class)
        ->assertSet('yon', '')
        ->set('name', 'Ayşe Yılmaz')
        ->set('unvan', 'Dr. Öğr. Üyesi')
        ->call('next')
        ->assertSet('yon', 'ileri')
        ->assertSeeHtml('wire:key="adim-2" data-adim="ileri"')
        ->call('back')
        ->assertSet('yon', 'geri')
        ->assertSeeHtml('data-adim="geri"');
});
