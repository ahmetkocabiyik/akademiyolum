<?php

use App\Enums\YoneticiIslemi;
use App\Enums\YzOzelligi;
use App\Enums\YzSaglayiciTuru;
use App\Livewire\Admin\YzAyarlari;
use App\Models\IslemKaydi;
use App\Models\User;
use App\Models\YzAyari;
use App\Services\AI\ClaudeSaglayici;
use App\Services\AI\JuriRaporcu;
use App\Services\AI\OpenAiSaglayici;
use App\Services\AI\SohbetSaglayici;
use App\Services\AI\StubJuriSaglayici;
use App\Services\AI\StubSaglayici;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

beforeEach(function () {
    config([
        'ai.saglayici' => 'stub',
        'ai.claude.anahtar' => 'sk-ant-test',
        'ai.claude.model' => 'claude-sonnet-5',
        'ai.openai.anahtar' => 'sk-test',
        'ai.openai.model' => 'gpt-4o',
    ]);

    $this->admin = User::factory()->onboarded()->create(['super_admin' => true]);
});

/** JuriRaporcu'ya enjekte edilen sağlayıcı (özel alan). */
function juriSaglayicisi(): SohbetSaglayici
{
    return (new ReflectionProperty(JuriRaporcu::class, 'saglayici'))->getValue(app(JuriRaporcu::class));
}

/** Sağlayıcının istekte göndereceği model. */
function saglayiciModeli(SohbetSaglayici $saglayici): string
{
    return (new ReflectionProperty($saglayici, 'model'))->getValue($saglayici);
}

// ── ÇÖZÜMLEME ─────────────────────────────────────────────────────────────

test('panelde seçim yoksa .env varsayılanı kullanılır', function () {
    config(['ai.saglayici' => 'openai']);

    expect(app(SohbetSaglayici::class))->toBeInstanceOf(OpenAiSaglayici::class)
        ->and(juriSaglayicisi())->toBeInstanceOf(OpenAiSaglayici::class);
});

test('danışman ve jüri sağlayıcısı ayrı ayrı seçilir', function () {
    YzAyari::query()->create(['ozellik' => 'danisman', 'saglayici' => 'claude', 'model' => 'claude-opus-5-5']);
    YzAyari::query()->create(['ozellik' => 'juri', 'saglayici' => 'openai']);

    $danisman = app(SohbetSaglayici::class);
    $juri = juriSaglayicisi();

    expect($danisman)->toBeInstanceOf(ClaudeSaglayici::class)
        ->and(saglayiciModeli($danisman))->toBe('claude-opus-5-5')
        ->and($juri)->toBeInstanceOf(OpenAiSaglayici::class)
        ->and(saglayiciModeli($juri))->toBe('gpt-4o')
        ->and((new ReflectionProperty($juri, 'maxTokens'))->getValue($juri))->toBe((int) config('ai.juri.max_tokens'));
});

test('sahte sağlayıcı özelliğe göre seçilir', function () {
    expect(app(SohbetSaglayici::class))->toBeInstanceOf(StubSaglayici::class)
        ->and(juriSaglayicisi())->toBeInstanceOf(StubJuriSaglayici::class);
});

test('seçili sağlayıcının anahtarı yoksa hata fırlatılır', function () {
    config(['ai.claude.anahtar' => null]);
    YzAyari::query()->create(['ozellik' => 'danisman', 'saglayici' => 'claude']);

    app(SohbetSaglayici::class);
})->throws(RuntimeException::class, 'ANTHROPIC_API_KEY tanımlı değil.');

// ── PANEL ─────────────────────────────────────────────────────────────────

test('panel sayfası açılır, yönetici olmayana 404', function () {
    actingAs($this->admin);
    get(route('admin.yz-ayarlari'))->assertOk()->assertSee('YZ Jüri Analizi')->assertSee('Claude (Anthropic)');

    actingAs(User::factory()->onboarded()->create());
    get(route('admin.yz-ayarlari'))->assertNotFound();
});

test('yönetici sağlayıcıyı ve modeli değiştirir, işlem kaydına yazılır', function () {
    actingAs($this->admin);

    Livewire::test(YzAyarlari::class)
        ->assertSet('ayarlar.danisman.saglayici', 'stub')
        ->set('ayarlar.danisman.saglayici', 'claude')
        ->set('ayarlar.danisman.model', 'claude-opus-5-5')
        ->call('kaydet', 'danisman')
        ->assertHasNoErrors();

    $ayar = YzAyari::query()->sole();

    expect($ayar->ozellik)->toBe(YzOzelligi::Danisman)
        ->and($ayar->saglayici)->toBe(YzSaglayiciTuru::Claude)
        ->and($ayar->model)->toBe('claude-opus-5-5')
        ->and($ayar->guncelleyen_id)->toBe($this->admin->id)
        ->and(app(SohbetSaglayici::class))->toBeInstanceOf(ClaudeSaglayici::class)
        ->and(juriSaglayicisi())->toBeInstanceOf(StubJuriSaglayici::class);

    $kayit = IslemKaydi::query()->sole();
    expect($kayit->islem)->toBe(YoneticiIslemi::YzAyariGuncelledi)
        ->and($kayit->detay['saglayici'])->toBe('Sahte yanıt (deneme) → Claude (Anthropic)');
});

test('boş model .env varsayılanına düşer', function () {
    actingAs($this->admin);

    Livewire::test(YzAyarlari::class)
        ->set('ayarlar.juri.saglayici', 'openai')
        ->set('ayarlar.juri.model', '  ')
        ->call('kaydet', 'juri')
        ->assertHasNoErrors();

    expect(YzAyari::query()->sole()->model)->toBeNull()
        ->and(saglayiciModeli(juriSaglayicisi()))->toBe('gpt-4o');
});

test('anahtarı olmayan sağlayıcı kaydedilemez', function () {
    config(['ai.openai.anahtar' => null]);
    actingAs($this->admin);

    Livewire::test(YzAyarlari::class)
        ->set('ayarlar.danisman.saglayici', 'openai')
        ->call('kaydet', 'danisman')
        ->assertHasErrors('ayarlar.danisman.saglayici');

    expect(YzAyari::query()->count())->toBe(0);
});

test('bilinmeyen sağlayıcı ve geçersiz model reddedilir', function () {
    actingAs($this->admin);

    Livewire::test(YzAyarlari::class)
        ->set('ayarlar.danisman.saglayici', 'gemini')
        ->call('kaydet', 'danisman')
        ->assertHasErrors('ayarlar.danisman.saglayici')
        ->set('ayarlar.danisman.saglayici', 'claude')
        ->set('ayarlar.danisman.model', 'model; rm -rf')
        ->call('kaydet', 'danisman')
        ->assertHasErrors('ayarlar.danisman.model');

    expect(YzAyari::query()->count())->toBe(0);
});

test('canlıda sahte sağlayıcı seçilemez', function () {
    app()->detectEnvironment(fn () => 'production');

    expect(YzSaglayiciTuru::secilebilenler())->toBe([YzSaglayiciTuru::Claude, YzSaglayiciTuru::OpenAi]);
});
