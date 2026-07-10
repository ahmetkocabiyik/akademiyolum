<?php

use App\Livewire\YzDanisman;
use App\Models\User;
use App\Services\AI\DanismanContext;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->user = User::factory()->onboarded()->create();
    actingAs($this->user);
});

test('danışman sayfası açılır', function () {
    $this->get(route('yz-danisman'))
        ->assertOk()
        ->assertSee('YZ Akademik Danışman')
        ->assertSee('Size nasıl yardımcı olabilirim?');
});

test('mesaj gönderince kullanıcı mesajı kaydedilir ve yanıt istenir', function () {
    Livewire::test(YzDanisman::class)
        ->set('mesaj', 'Doçentlik için ne yapmalıyım?')
        ->call('gonder')
        ->assertSet('mesaj', '')
        ->assertSet('bekleniyor', true)
        ->assertDispatched('danisman-yanit-al');

    expect($this->user->danismanMesajlari()->where('rol', 'user')->count())->toBe(1)
        ->and($this->user->danismanMesajlari()->where('rol', 'assistant')->count())->toBe(0);
});

test('yanıt alınınca asistan mesajı kaydedilir (stub)', function () {
    Livewire::test(YzDanisman::class)
        ->set('mesaj', 'Merhaba')
        ->call('gonder')
        ->call('yanitAl')
        ->assertSet('bekleniyor', false)
        ->assertSee('yol haritası');

    $asistan = $this->user->danismanMesajlari()->where('rol', 'assistant')->sole();

    expect($asistan->icerik)->toContain('SCI/SSCI');
});

test('boş mesaj doğrulanır', function () {
    Livewire::test(YzDanisman::class)
        ->set('mesaj', '')
        ->call('gonder')
        ->assertHasErrors(['mesaj']);

    expect($this->user->danismanMesajlari()->count())->toBe(0);
});

test('hazır öneri gönderilir', function () {
    Livewire::test(YzDanisman::class)
        ->call('oneriGonder', 'Hangi kategoride eksiğim var?')
        ->assertDispatched('danisman-yanit-al');

    expect($this->user->danismanMesajlari()->where('rol', 'user')->sole()->icerik)
        ->toBe('Hangi kategoride eksiğim var?');
});

test('sohbet temizlenir', function () {
    $this->user->danismanMesajlari()->create(['rol' => 'user', 'icerik' => 'test']);

    Livewire::test(YzDanisman::class)
        ->call('sohbetiTemizle');

    expect($this->user->danismanMesajlari()->count())->toBe(0);
});

test('sistem promptu profil ve puan verisini içerir', function () {
    $prompt = (new DanismanContext)->sistemPrompt($this->user->refresh());

    expect($prompt)->toContain($this->user->name)
        ->and($prompt)->toContain('İlahiyat 2026')
        ->and($prompt)->toContain('Toplam Puan')
        ->and($prompt)->toContain('ÜAK Hedefi');
});

test('başka kullanıcının mesajları görünmez', function () {
    $baskasi = User::factory()->create();
    $baskasi->danismanMesajlari()->create(['rol' => 'user', 'icerik' => 'gizli mesaj']);

    Livewire::test(YzDanisman::class)
        ->assertDontSee('gizli mesaj');
});
