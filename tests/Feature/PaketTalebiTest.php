<?php

use App\Enums\Plan;
use App\Enums\YoneticiIslemi;
use App\Livewire\Admin\Abonelikler;
use App\Livewire\Dashboard;
use App\Livewire\Onboarding;
use App\Mail\SablonluEposta;
use App\Models\AbonelikTalebi;
use App\Models\IslemKaydi;
use App\Models\Paket;
use App\Models\User;
use App\Services\Abonelik\AbonelikTalepleri;
use App\Services\Abonelik\PaketKatalogu;
use App\Services\Yonetim\KullaniciYonetimi;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Mail;
use Livewire\Features\SupportTesting\Testable;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    Mail::fake();
    CarbonImmutable::setTestNow('2026-10-08');

    $this->admin = User::factory()->onboarded()->create(['email' => 'admin@ornek.test', 'super_admin' => true]);
});

afterEach(fn () => CarbonImmutable::setTestNow());

/** Kurulumu üç adımda doldurur; paket adımında bırakır. */
function paketAdiminaKadar(): Testable
{
    return Livewire::test(Onboarding::class)
        ->set('name', 'Ayşe Yılmaz')
        ->set('unvan', 'Dr. Öğr. Üyesi')
        ->call('next')
        ->set('universite', 'Mersin Üniversitesi')
        ->set('temelAlan', 'ilahiyat')
        ->call('next')
        ->assertSet('step', 3);
}

/** @return list<string> Kuyruğa düşen mail konuları, alıcıyla: "alıcı: konu". */
function talepMailleri(): array
{
    $konular = [];

    Mail::assertQueued(SablonluEposta::class, function (SablonluEposta $mail) use (&$konular) {
        $konular[] = $mail->to[0]['address'].': '.$mail->konu;

        return true;
    });

    return $konular;
}

// ── KAYIT → KURULUM ───────────────────────────────────────────────────────

test('tanıtım sayfasındaki paket kartı kayda paketi taşır, kurulumda önceden seçili gelir', function () {
    $this->get('/')->assertSee(route('register', ['paket' => 'akademisyen']), false);
    $this->get(route('register', ['paket' => 'akademisyen']))->assertSee('name="paket" value="akademisyen"', false);
    $this->get(route('register', ['paket' => 'uydurma']))->assertDontSee('name="paket"', false);

    $this->post(route('register.store'), [
        'name' => 'Ayşe Yılmaz',
        'email' => 'ayse@ornek.test',
        'password' => 'Gizli-sifre-123!',
        'password_confirmation' => 'Gizli-sifre-123!',
        'paket' => 'akademisyen',
    ])->assertSessionHas(Onboarding::SECILEN_PAKET, 'akademisyen');

    actingAs(User::query()->where('email', 'ayse@ornek.test')->sole());
    Livewire::test(Onboarding::class)->assertSet('paket', 'akademisyen');
});

test('ücretsiz seçen kullanıcı için talep oluşmaz', function () {
    $user = User::factory()->create();
    actingAs($user);

    paketAdiminaKadar()->assertSet('paket', 'ucretsiz')->call('submit')->assertHasNoErrors();

    expect($user->refresh()->hasCompletedOnboarding())->toBeTrue()
        ->and(AbonelikTalebi::query()->count())->toBe(0);
});

test('ücretli paket seçilince talep oluşur, kullanıcıya ve yöneticiye mail gider, panelde bant görünür', function () {
    app(PaketKatalogu::class)->bilgi(Plan::Akademisyen)->update(['yillik_fiyat_kurus' => 299000]);
    $user = User::factory()->create(['email' => 'ayse@ornek.test']);
    actingAs($user)->withSession([Onboarding::SECILEN_PAKET => 'akademisyen']);

    paketAdiminaKadar()
        ->set('donem', 'yillik')
        ->assertSee('Talep Et ve Tamamla')
        ->call('submit')
        ->assertHasNoErrors();

    $talep = AbonelikTalebi::query()->sole();
    expect($talep->user_id)->toBe($user->id)
        ->and($talep->plan)->toBe(Plan::Akademisyen)
        ->and($talep->donem)->toBe('yillik')
        ->and($talep->durum)->toBe(AbonelikTalebi::BEKLIYOR)
        ->and(session()->has(Onboarding::SECILEN_PAKET))->toBeFalse()
        ->and(talepMailleri())->toEqualCanonicalizing([
            'ayse@ornek.test: Akademisyen paket talebiniz alındı',
            'admin@ornek.test: Paket talebi: '.$user->refresh()->name.' · Akademisyen (Yıllık)',
        ]);

    Livewire::test(Dashboard::class)->assertSee('Akademisyen (yıllık) paket talebiniz alındı.');
});

test('yıllık fiyatı olmayan pakette yıllık dönem seçilemez', function () {
    app(PaketKatalogu::class)->bilgi(Plan::Akademisyen)->update(['yillik_fiyat_kurus' => null]);
    actingAs(User::factory()->create());

    paketAdiminaKadar()
        ->set('paket', 'akademisyen')
        ->set('donem', 'yillik')
        ->call('submit')
        ->assertHasErrors('donem');

    expect(AbonelikTalebi::query()->count())->toBe(0);
});

test('satışta olmayan paket seçilemez, ücretsiz her zaman seçilebilir', function () {
    Paket::query()->delete();
    app(PaketKatalogu::class)->yenile();
    app(PaketKatalogu::class)->bilgi(Plan::Kurumsal)->update(['satista' => false]);
    app(PaketKatalogu::class)->bilgi(Plan::Ucretsiz)->update(['satista' => false]);
    app(PaketKatalogu::class)->yenile();
    actingAs(User::factory()->create());

    paketAdiminaKadar()
        ->assertSee('Akademisyen')
        ->set('paket', 'kurumsal')
        ->call('submit')
        ->assertHasErrors('paket')
        ->set('paket', 'ucretsiz')
        ->call('submit')
        ->assertHasNoErrors();
});

// ── YÖNETİCİ ──────────────────────────────────────────────────────────────

test('yönetici talebi onaylayınca paket fiyatıyla abonelik açılır, talep tamamlanır', function () {
    $talep = AbonelikTalebi::factory()->create(['donem' => 'aylik']);
    actingAs($this->admin);

    $this->get(route('admin.abonelikler'))->assertSee('Bekleyen paket talepleri')->assertSee($talep->user->email);

    Livewire::test(Abonelikler::class)->call('talebiOnayla', $talep->id);

    $talep->refresh();
    $abonelik = $talep->user->aktifAbonelik();

    expect($talep->durum)->toBe(AbonelikTalebi::TAMAMLANDI)
        ->and($talep->abonelik_id)->toBe($abonelik->id)
        ->and($talep->sonuclandiran_id)->toBe($this->admin->id)
        ->and($abonelik->plan)->toBe(Plan::Akademisyen)
        ->and($abonelik->baslangic->toDateString())->toBe('2026-10-08')
        ->and($abonelik->bitis->toDateString())->toBe('2026-11-07')
        ->and($abonelik->tutar_kurus)->toBe(29900)
        ->and(IslemKaydi::query()->sole()->detay['talep_id'])->toBe($talep->id);

    $this->get(route('admin.abonelikler'))->assertDontSee('Bekleyen paket talepleri');
});

test('panelden elle eklenen abonelik bekleyen talebi de karşılar', function () {
    $talep = AbonelikTalebi::factory()->create();

    app(KullaniciYonetimi::class)->abonelikEkle($talep->user, $this->admin, Plan::Kurumsal, CarbonImmutable::today(), null);

    expect($talep->refresh()->durum)->toBe(AbonelikTalebi::TAMAMLANDI);
});

test('kapatılan talep listeden düşer, kullanıcıya mail gitmez, kayda yazılır', function () {
    $talep = AbonelikTalebi::factory()->create();
    actingAs($this->admin);

    Livewire::test(Abonelikler::class)->call('talebiKapat', $talep->id);

    expect($talep->refresh()->durum)->toBe(AbonelikTalebi::KAPATILDI)
        ->and($talep->user->aktifAbonelik())->toBeNull()
        ->and(IslemKaydi::query()->sole()->islem)->toBe(YoneticiIslemi::TalebiKapatti);
    Mail::assertNothingQueued();
});

test('sonuçlanmış talep yeniden onaylanamaz; yeni talep eskisinin yerini alır', function () {
    $user = User::factory()->onboarded()->create();
    $ilk = AbonelikTalebi::factory()->for($user)->create();
    actingAs($user);

    app(AbonelikTalepleri::class)->olustur($user, Plan::Kurumsal, 'aylik');

    expect($ilk->refresh()->durum)->toBe(AbonelikTalebi::KAPATILDI)
        ->and($user->bekleyenTalep()->plan)->toBe(Plan::Kurumsal);

    actingAs($this->admin);
    Livewire::test(Abonelikler::class)->call('talebiOnayla', $ilk->id);
})->throws(ModelNotFoundException::class);

test('yetkisi alınan yöneticinin açık paneli işlem yapamaz (ara katman Livewire isteklerinde de çalışır)', function () {
    $talep = AbonelikTalebi::factory()->create();
    actingAs($this->admin);

    $sayfa = $this->get(route('admin.abonelikler'))->assertOk()->getContent();
    preg_match_all('/wire:snapshot="([^"]+)"/', $sayfa, $eslesmeler);
    $snapshot = collect($eslesmeler[1])->map(fn (string $s): string => html_entity_decode($s))
        ->first(fn (string $s): bool => json_decode($s, true)['memo']['name'] === 'admin.abonelikler');

    $istek = fn () => $this->withHeaders(['X-Livewire' => '1'])->postJson(Livewire::getUpdateUri(), [
        '_token' => csrf_token(),
        'components' => [['snapshot' => $snapshot, 'updates' => [], 'calls' => [['path' => '', 'method' => 'talebiKapat', 'params' => [$talep->id]]]]],
    ]);

    // super_admin toplu atanamıyor (yalnız admin:yap komutu).
    $this->admin->forceFill(['super_admin' => false])->save();
    $istek()->assertNotFound();
    expect($talep->refresh()->durum)->toBe(AbonelikTalebi::BEKLIYOR);
});
