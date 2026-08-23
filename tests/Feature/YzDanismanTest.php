<?php

use App\Livewire\YzDanisman;
use App\Models\DanismanSohbet;
use App\Models\User;
use App\Services\AI\DanismanContext;
use App\Services\AI\SaglayiciException;
use App\Services\AI\SohbetSaglayici;
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

test('ilk mesaj yeni bir sohbet oluşturur ve başlığı mesajdan türetir', function () {
    Livewire::test(YzDanisman::class)
        ->set('mesaj', 'Doçentlik için ne yapmalıyım?')
        ->call('gonder')
        ->assertSet('mesaj', '')
        ->assertSet('bekleniyor', true)
        ->assertDispatched('danisman-yanit-al');

    $sohbet = $this->user->danismanSohbetleri()->sole();

    expect($sohbet->baslik)->toBe('Doçentlik için ne yapmalıyım?')
        ->and($sohbet->mesajlar()->where('rol', 'user')->count())->toBe(1)
        ->and($sohbet->mesajlar()->where('rol', 'assistant')->count())->toBe(0);
});

test('yanıt alınınca asistan mesajı aktif sohbete kaydedilir (stub)', function () {
    Livewire::test(YzDanisman::class)
        ->set('mesaj', 'Merhaba')
        ->call('gonder')
        ->call('yanitAl')
        ->assertSet('bekleniyor', false)
        ->assertSee('yol haritası');

    $sohbet = $this->user->danismanSohbetleri()->sole();
    $asistan = $sohbet->mesajlar()->where('rol', 'assistant')->sole();

    expect($asistan->icerik)->toContain('SCI/SSCI');
});

test('aynı sohbette gönderilen ikinci mesaj yeni sohbet açmaz', function () {
    $component = Livewire::test(YzDanisman::class)
        ->set('mesaj', 'İlk soru')
        ->call('gonder')
        ->call('yanitAl')
        ->set('mesaj', 'İkinci soru')
        ->call('gonder');

    expect($this->user->danismanSohbetleri()->count())->toBe(1)
        ->and($this->user->danismanSohbetleri()->sole()->mesajlar()->where('rol', 'user')->count())->toBe(2);
});

test('yeni sohbet aktif sohbeti sıfırlar', function () {
    Livewire::test(YzDanisman::class)
        ->set('mesaj', 'İlk soru')
        ->call('gonder')
        ->call('yanitAl')
        ->assertSet('aktifSohbetId', fn ($id) => $id !== null)
        ->call('yeniSohbet')
        ->assertSet('aktifSohbetId', null)
        ->assertSee('Size nasıl yardımcı olabilirim?');
});

test('geçmiş bir sohbet seçilebilir', function () {
    $eski = DanismanSohbet::factory()->for($this->user)->create(['baslik' => 'Eski sohbet']);
    $eski->mesajlar()->create(['user_id' => $this->user->id, 'rol' => 'user', 'icerik' => 'eski mesaj']);

    Livewire::test(YzDanisman::class)
        ->call('sohbetSec', $eski->id)
        ->assertSet('aktifSohbetId', $eski->id)
        ->assertSee('eski mesaj');
});

test('sohbet silinir', function () {
    $sohbet = DanismanSohbet::factory()->for($this->user)->create();
    $sohbet->mesajlar()->create(['user_id' => $this->user->id, 'rol' => 'user', 'icerik' => 'silinecek']);

    Livewire::test(YzDanisman::class)
        ->call('sohbetiSil', $sohbet->id);

    expect($this->user->danismanSohbetleri()->count())->toBe(0)
        ->and($this->user->danismanMesajlari()->count())->toBe(0);
});

test('başka kullanıcının sohbeti seçilemez ve silinemez', function () {
    $baskasi = User::factory()->create();
    $sohbet = DanismanSohbet::factory()->for($baskasi)->create(['baslik' => 'gizli sohbet']);

    Livewire::test(YzDanisman::class)
        ->call('sohbetSec', $sohbet->id)
        ->assertSet('aktifSohbetId', null)
        ->call('sohbetiSil', $sohbet->id);

    expect(DanismanSohbet::whereKey($sohbet->id)->exists())->toBeTrue();
});

test('aktifSohbetId elle değiştirilse bile başka kullanıcının mesajları sızmaz', function () {
    $baskasi = User::factory()->create();
    $sohbet = DanismanSohbet::factory()->for($baskasi)->create();
    $sohbet->mesajlar()->create(['user_id' => $baskasi->id, 'rol' => 'user', 'icerik' => 'gizli içerik']);

    Livewire::test(YzDanisman::class)
        ->set('aktifSohbetId', $sohbet->id)
        ->assertDontSee('gizli içerik');
});

test('sağlayıcı hatası kullanıcıya anlaşılır mesajla gösterilir', function () {
    $this->app->bind(SohbetSaglayici::class, fn () => new class implements SohbetSaglayici
    {
        public function yanitla(string $sistemPrompt, array $mesajlar): string
        {
            throw SaglayiciException::httpDurumundan(429);
        }
    });

    Livewire::test(YzDanisman::class)
        ->set('mesaj', 'Merhaba')
        ->call('gonder')
        ->call('yanitAl')
        ->assertSet('bekleniyor', false)
        ->assertSet('hata', 'Kullanım limitiniz dolmuş görünüyor. Lütfen sağlayıcı hesabınıza bakiye yükleyip tekrar deneyin.')
        ->assertSee('bakiye yükleyip');

    expect($this->user->danismanMesajlari()->where('rol', 'assistant')->count())->toBe(0);
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

test('sistem promptu profil ve değerlendirme verisini içerir', function () {
    $prompt = app(DanismanContext::class)->sistemPrompt($this->user->refresh());

    expect($prompt)->toContain($this->user->name)
        ->and($prompt)->toContain('AKADEMİSYEN PROFİLİ')
        ->and($prompt)->toContain('YÖNERGE DEĞERLENDİRMESİ')
        ->and($prompt)->toContain('FAALİYET DAĞILIMI')
        // Kullanıcı Mersin'de ve Mersin'in verisi girili → gerçek değerlendirme.
        // Kullanıcı Mersin'de (onboarded fabrikası) ve Mersin'in verisi girili
        // → prompt gerçek eşik değerlendirmesini taşır, uydurma puan taşımaz.
        ->and($prompt)->toContain('Genel sonuç:')
        ->and($prompt)->toContain('Yayın ve proje kalemlerinden toplam en az 220 puan')
        // Modele "belirsiz ≠ sağlanmadı" talimatı veriliyor.
        ->and($prompt)->toContain('SAĞLANMADIĞI anlamına GELMEZ');
});

test('başka kullanıcının sohbetleri listede görünmez', function () {
    $baskasi = User::factory()->create();
    DanismanSohbet::factory()->for($baskasi)->create(['baslik' => 'gizli sohbet']);

    Livewire::test(YzDanisman::class)
        ->assertDontSee('gizli sohbet');
});
