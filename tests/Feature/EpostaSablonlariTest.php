<?php

use App\Enums\EpostaTuru;
use App\Enums\Plan;
use App\Enums\YoneticiIslemi;
use App\Livewire\Admin\EpostaSablonuDuzenle;
use App\Mail\SablonluEposta;
use App\Models\EpostaSablonu;
use App\Models\IslemKaydi;
use App\Models\User;
use App\Services\Eposta\EpostaGonderici;
use App\Services\Yonetim\KullaniciYonetimi;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    Mail::fake();

    $this->admin = User::factory()->onboarded()->create(['email' => 'admin@ornek.test', 'super_admin' => true]);
});

/** Kuyruğa düşen şablonlu mailler, alıcıya göre. */
function giden(): array
{
    $mailler = [];

    Mail::assertQueued(SablonluEposta::class, function (SablonluEposta $mail) use (&$mailler) {
        $mailler[$mail->to[0]['address']][] = $mail;

        return true;
    });

    return $mailler;
}

// ── KAYIT ─────────────────────────────────────────────────────────────────

test('kayıt olunca kullanıcıya hoş geldin, yöneticilere bildirim gider', function () {
    User::factory()->create(['email' => 'askidaki-admin@ornek.test', 'super_admin' => true, 'askiya_alindi_at' => now()]);

    $this->post(route('register.store'), [
        'name' => 'Ayşe Yılmaz',
        'email' => 'ayse@ornek.test',
        'password' => 'password',
        'password_confirmation' => 'password',
    ])->assertSessionHasNoErrors();

    $mailler = giden();

    expect(array_keys($mailler))->toEqualCanonicalizing(['ayse@ornek.test', 'admin@ornek.test'])
        ->and($mailler['ayse@ornek.test'][0]->konu)->toBe('Akademiyolum\'a hoş geldiniz')
        ->and($mailler['ayse@ornek.test'][0]->govdeHtml)->toContain('Merhaba Ayşe Yılmaz')->toContain(route('login'))
        ->and($mailler['admin@ornek.test'][0]->konu)->toBe('Yeni kayıt: Ayşe Yılmaz')
        ->and($mailler['admin@ornek.test'][0]->govdeHtml)->toContain('ayse@ornek.test');
});

test('mailler kuyruğa ve veritabanı işlemi tamamlandıktan sonra gider', function () {
    $mail = app(EpostaGonderici::class)->olustur('k', 'g', []);

    expect($mail)->toBeInstanceOf(ShouldQueue::class)
        ->and($mail->afterCommit)->toBeTrue();
});

// ── ABONELİK ──────────────────────────────────────────────────────────────

test('abonelik tanımlanınca kullanıcıya ve yöneticiye plan, dönem ve tutarla mail gider', function () {
    $uye = User::factory()->create(['name' => 'Mehmet Demir', 'email' => 'mehmet@ornek.test']);

    app(KullaniciYonetimi::class)->abonelikEkle(
        $uye, $this->admin, Plan::Kurumsal,
        CarbonImmutable::parse('2026-10-08'), CarbonImmutable::parse('2027-10-07'), 1198800,
    );

    $mailler = giden();
    $kullaniciya = $mailler['mehmet@ornek.test'][0];
    $yoneticiye = $mailler['admin@ornek.test'][0];

    expect($kullaniciya->konu)->toBe('Kurumsal aboneliğiniz başladı')
        ->and($kullaniciya->govdeHtml)->toContain('8 Ekim 2026')->toContain('7 Ekim 2027')->toContain('11.988,00 ₺')
        ->and($yoneticiye->konu)->toBe('Yeni abonelik: Mehmet Demir · Kurumsal')
        ->and($yoneticiye->govdeHtml)->toContain(e($this->admin->name))->toContain(route('admin.kullanici', $uye));
});

test('süresiz ve tutarsız abonelik metni', function () {
    $uye = User::factory()->create(['email' => 'mehmet@ornek.test']);

    app(KullaniciYonetimi::class)->abonelikEkle($uye, $this->admin, Plan::Akademisyen, CarbonImmutable::today(), null);

    expect(giden()['mehmet@ornek.test'][0]->govdeHtml)->toContain('süresiz')->toContain('—');
});

// ── ŞABLON KULLANIMI ──────────────────────────────────────────────────────

test('panelde düzenlenen şablon varsayılanın yerine kullanılır', function () {
    EpostaSablonu::query()->create([
        'tur' => EpostaTuru::KayitKullanici->value,
        'konu' => 'Selam {ad}!',
        'govde' => 'Özel karşılama metni, {ad}.',
    ]);

    app(EpostaGonderici::class)->kayit(User::factory()->create(['name' => 'Zeynep', 'email' => 'zeynep@ornek.test']));

    $mail = giden()['zeynep@ornek.test'][0];
    expect($mail->konu)->toBe('Selam Zeynep!')
        ->and($mail->govdeHtml)->toContain('Özel karşılama metni, Zeynep.');
});

test('kapatılan şablon gönderilmez, diğerleri gider', function () {
    EpostaSablonu::query()->create([
        'tur' => EpostaTuru::KayitYonetici->value,
        'konu' => EpostaTuru::KayitYonetici->varsayilanKonu(),
        'govde' => EpostaTuru::KayitYonetici->varsayilanGovde(),
        'aktif' => false,
    ]);

    app(EpostaGonderici::class)->kayit(User::factory()->create(['email' => 'zeynep@ornek.test']));

    expect(array_keys(giden()))->toBe(['zeynep@ornek.test']);
});

test('kullanıcıdan gelen değer HTML olarak çalışmaz; şablondaki ham HTML ve javascript bağlantısı da', function () {
    EpostaSablonu::query()->create([
        'tur' => EpostaTuru::KayitKullanici->value,
        'konu' => 'Merhaba {ad}',
        'govde' => "Merhaba {ad}\n\n<script>alert(1)</script>\n\n[tıkla](javascript:alert(1))",
    ]);

    app(EpostaGonderici::class)->kayit(User::factory()->create(['name' => '<img src=x onerror=alert(1)>', 'email' => 'x@ornek.test']));

    $html = giden()['x@ornek.test'][0]->govdeHtml;

    expect($html)->not->toContain('<img')->not->toContain('<script>')->not->toContain('javascript:')
        ->and($html)->toContain('&lt;img');
});

test('tanımsız değişken olduğu gibi kalır ve panelde uyarılır', function () {
    $gonderici = app(EpostaGonderici::class);

    expect($gonderici->olustur('{adi}', 'Merhaba {adi} {ad}', ['ad' => 'Ali'])->duzMetin)->toBe('Merhaba {adi} Ali')
        ->and($gonderici->bilinmeyenDegiskenler(EpostaTuru::KayitKullanici, 'Merhaba {adi} {ad} {plan}'))->toBe(['adi', 'plan']);
});

// ── PANEL ─────────────────────────────────────────────────────────────────

test('şablon ekranları yalnızca süper admine açık', function () {
    $adresler = [route('admin.eposta-sablonlari'), route('admin.eposta-sablonu', EpostaTuru::AbonelikKullanici)];

    actingAs(User::factory()->onboarded()->create());
    foreach ($adresler as $adres) {
        $this->get($adres)->assertNotFound();
    }

    actingAs($this->admin);
    foreach ($adresler as $adres) {
        $this->get($adres)->assertOk();
    }

    $this->get('/admin/eposta-sablonlari/olmayan')->assertNotFound();
});

test('düzenleme ekranı varsayılanla açılır, kaydedince saklanır ve kaydedilir', function () {
    actingAs($this->admin);

    Livewire::test(EpostaSablonuDuzenle::class, ['tur' => EpostaTuru::AbonelikKullanici])
        ->assertSet('konu', '{plan} aboneliğiniz başladı')
        ->assertSet('ozel', false)
        ->set('konu', 'Hoş geldiniz: {plan}')
        ->set('aktif', false)
        ->call('kaydet')
        ->assertHasNoErrors()
        ->assertSet('ozel', true);

    $kayit = EpostaSablonu::query()->sole();
    expect($kayit->tur)->toBe(EpostaTuru::AbonelikKullanici)
        ->and($kayit->konu)->toBe('Hoş geldiniz: {plan}')
        ->and($kayit->aktif)->toBeFalse()
        ->and($kayit->guncelleyen_id)->toBe($this->admin->id)
        ->and(IslemKaydi::query()->sole()->islem)->toBe(YoneticiIslemi::SablonGuncelledi);
});

test('boş konu ya da içerik kaydedilemez', function () {
    actingAs($this->admin);

    Livewire::test(EpostaSablonuDuzenle::class, ['tur' => EpostaTuru::KayitKullanici])
        ->set('konu', '')
        ->set('govde', '')
        ->call('kaydet')
        ->assertHasErrors(['konu', 'govde']);

    expect(EpostaSablonu::query()->count())->toBe(0);
});

test('varsayılana dön panel kaydını siler', function () {
    EpostaSablonu::query()->create(['tur' => EpostaTuru::KayitKullanici->value, 'konu' => 'Eski', 'govde' => 'Eski', 'aktif' => false]);

    actingAs($this->admin);
    Livewire::test(EpostaSablonuDuzenle::class, ['tur' => EpostaTuru::KayitKullanici])
        ->assertSet('konu', 'Eski')
        ->call('varsayilanaDon')
        ->assertSet('konu', EpostaTuru::KayitKullanici->varsayilanKonu())
        ->assertSet('aktif', true)
        ->assertSet('ozel', false);

    expect(EpostaSablonu::query()->count())->toBe(0)
        ->and(IslemKaydi::query()->sole()->islem)->toBe(YoneticiIslemi::SablonSifirladi);
});

test('önizleme örnek değerlerle, tanımsız değişken uyarısıyla çizilir', function () {
    actingAs($this->admin);

    Livewire::test(EpostaSablonuDuzenle::class, ['tur' => EpostaTuru::KayitYonetici])
        ->set('govde', 'Yeni üye: {ad} — {universite} {kurum}')
        ->assertSee('Yeni üye: Ayşe Yılmaz — Mersin Üniversitesi {kurum}')
        ->assertSee('Bu şablonda tanımlı olmayan değişken');
});

test('önizlemede başlık logosu görünür', function () {
    actingAs($this->admin);

    Livewire::test(EpostaSablonuDuzenle::class, ['tur' => EpostaTuru::KayitYonetici])
        ->assertSee(asset('apple-touch-icon.png'), false);
});

test('test gönderimi ekrandaki hâli yöneticinin kendi adresine yollar', function () {
    actingAs($this->admin);

    Livewire::test(EpostaSablonuDuzenle::class, ['tur' => EpostaTuru::AbonelikKullanici])
        ->set('konu', 'Deneme {plan}')
        ->call('testGonder');

    $mail = giden()['admin@ornek.test'][0];
    expect($mail->konu)->toBe('[Test] Deneme Akademisyen');
});
