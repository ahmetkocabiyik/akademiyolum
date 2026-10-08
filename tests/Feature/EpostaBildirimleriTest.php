<?php

use App\Enums\EpostaTuru;
use App\Enums\Plan;
use App\Livewire\Admin\EpostaSablonuDuzenle;
use App\Mail\SablonluEposta;
use App\Models\Abonelik;
use App\Models\EpostaSablonu;
use App\Models\User;
use App\Services\Yonetim\KullaniciYonetimi;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    Mail::fake();

    $this->admin = User::factory()->onboarded()->create(['email' => 'admin@ornek.test', 'super_admin' => true]);
    $this->uye = User::factory()->onboarded()->create(['name' => 'Ayşe Yılmaz', 'email' => 'ayse@ornek.test']);
    $this->yonetim = app(KullaniciYonetimi::class);
});

/**
 * Kuyruğa düşen şablonlu mailler: `alıcı => [konu, ...]`.
 *
 * @return array<string, list<SablonluEposta>>
 */
function kuyruktakiler(): array
{
    $mailler = [];

    Mail::assertQueued(SablonluEposta::class, function (SablonluEposta $mail) use (&$mailler) {
        $mailler[$mail->to[0]['address']][] = $mail;

        return true;
    });

    return $mailler;
}

function hicMailYok(): void
{
    Mail::assertNothingQueued();
}

// ── ŞİFRE SIFIRLAMA VE DOĞRULAMA ──────────────────────────────────────────

test('şifre sıfırlama maili Türkçe şablondan gider ve bağlantısı şifreyi gerçekten sıfırlar', function () {
    // Bildirim Laravel'in (ResetPassword); METNİ bizim şablonumuzdan. Mail
    // sahtesi bildirimden gelen maili kaydetmediği için bildirim sahteleniyor
    // ve ürettiği mail inceleniyor.
    Notification::fake();

    $this->post(route('password.request'), ['email' => 'ayse@ornek.test']);

    $mail = null;
    Notification::assertSentTo($this->uye, ResetPassword::class, function (ResetPassword $bildirim) use (&$mail) {
        $mail = $bildirim->toMail($this->uye);

        return true;
    });

    expect($mail)->toBeInstanceOf(SablonluEposta::class)
        ->and($mail->hasTo('ayse@ornek.test'))->toBeTrue()
        ->and($mail->konu)->toBe('Akademiyolum şifre sıfırlama')
        ->and($mail->govdeHtml)->toContain('Merhaba Ayşe Yılmaz')->toContain('60 dakika');

    preg_match('#/reset-password/([^?"]+)\?email=#', html_entity_decode($mail->govdeHtml), $eslesme);

    $this->post(route('password.update'), [
        'token' => $eslesme[1],
        'email' => 'ayse@ornek.test',
        'password' => 'yeni-sifre-123',
        'password_confirmation' => 'yeni-sifre-123',
    ])->assertSessionHasNoErrors();

    expect(Hash::check('yeni-sifre-123', $this->uye->fresh()->password))->toBeTrue();
});

test('şifre sıfırlama şablonu panelde kapalı kaydedilse bile gider', function () {
    EpostaSablonu::query()->create([
        'tur' => EpostaTuru::SifreSifirlama->value, 'konu' => 'Özel: {ad}', 'govde' => 'Bağlantı: {sifirlama_adresi}', 'aktif' => false,
    ]);

    expect((new ResetPassword('anahtar'))->toMail($this->uye)->konu)->toBe('Özel: Ayşe Yılmaz');
});

test('e-posta doğrulama maili şablondan, imzalı bağlantıyla gider', function () {
    Notification::fake();

    $this->uye->sendEmailVerificationNotification();

    Notification::assertSentTo($this->uye, VerifyEmail::class, function (VerifyEmail $bildirim) {
        $mail = $bildirim->toMail($this->uye);

        return $mail instanceof SablonluEposta
            && $mail->hasTo('ayse@ornek.test')
            && $mail->konu === 'E-posta adresinizi doğrulayın'
            && str_contains($mail->govdeHtml, '/email/verify/')
            && str_contains($mail->govdeHtml, 'signature=');
    });
});

test('panelde kapatılamayan şablonda anahtar yok, kapalı kaydedilemez', function () {
    actingAs($this->admin);

    Livewire::test(EpostaSablonuDuzenle::class, ['tur' => EpostaTuru::SifreSifirlama])
        ->assertDontSee('Bu e-posta gönderilsin')
        ->set('aktif', false)
        ->call('kaydet');

    expect(EpostaSablonu::query()->sole()->aktif)->toBeTrue();
});

// ── HESAP İŞLEMLERİ ───────────────────────────────────────────────────────

test('askıya alınınca nedenle, askı kalkınca bilgi maili gider', function () {
    $this->yonetim->askiyaAl($this->uye, $this->admin, 'Ödeme itirazı');
    $this->yonetim->askidanCikar($this->uye->fresh(), $this->admin);

    $mailler = kuyruktakiler()['ayse@ornek.test'];

    expect(array_map(fn ($m) => $m->konu, $mailler))->toBe([
        'Akademiyolum hesabınız askıya alındı',
        'Akademiyolum hesabınız yeniden açıldı',
    ])->and($mailler[0]->govdeHtml)->toContain('Ödeme itirazı');
});

test('nedensiz askıda "belirtilmedi" yazar', function () {
    $this->yonetim->askiyaAl($this->uye, $this->admin);

    expect(kuyruktakiler()['ayse@ornek.test'][0]->govdeHtml)->toContain('belirtilmedi');
});

test('hesap silinince silinen adrese teyit gider', function () {
    $this->yonetim->sil($this->uye, $this->admin);

    $mail = kuyruktakiler()['ayse@ornek.test'][0];
    expect($mail->konu)->toBe('Akademiyolum hesabınız silindi')
        ->and($mail->govdeHtml)->toContain('Ayşe Yılmaz')->toContain('ayse@ornek.test');
});

test('aktif abonelik iptalinde mail gider, bitmiş dönemin iptalinde gitmez', function () {
    $aktif = Abonelik::factory()->for($this->uye)->create();
    $biten = Abonelik::factory()->for($this->uye)->bitmis()->create();

    $this->yonetim->abonelikIptal($biten, $this->admin);
    hicMailYok();

    $this->yonetim->abonelikIptal($aktif, $this->admin);
    expect(kuyruktakiler()['ayse@ornek.test'][0]->konu)->toBe('Akademisyen aboneliğiniz iptal edildi');
});

// ── ZAMANLANMIŞ GÖREV ─────────────────────────────────────────────────────

test('bitişine 7 gün kalan aboneliğe bir kez hatırlatma, yöneticilere özet gider', function () {
    $this->travelTo('2026-10-08 09:00');
    Abonelik::factory()->for($this->uye)->create(['baslangic' => '2026-09-15', 'bitis' => '2026-10-15']);

    $this->artisan('abonelik:bildir')->assertSuccessful();

    $mailler = kuyruktakiler();
    expect($mailler['ayse@ornek.test'][0]->konu)->toBe('Akademisyen aboneliğiniz 7 gün sonra bitiyor')
        ->and($mailler['ayse@ornek.test'][0]->govdeHtml)->toContain('15 Ekim 2026')
        ->and($mailler['admin@ornek.test'][0]->konu)->toBe('1 abonelik yakında bitiyor')
        ->and($mailler['admin@ornek.test'][0]->govdeHtml)->toContain('Ayşe Yılmaz')->toContain('ayse@ornek.test')->toContain('15 Ekim 2026');

    // Ertesi gün tekrar çalışınca aynı abonelik için ikinci hatırlatma yok.
    Mail::fake();
    $this->travelTo('2026-10-09 09:00');
    $this->artisan('abonelik:bildir')->assertSuccessful();
    hicMailYok();
});

test('bitişine 7 günden çok kalan, süresiz, iptal edilmiş ya da yenilenmiş aboneliğe hatırlatma gitmez', function () {
    $this->travelTo('2026-10-08 09:00');
    $baska = User::factory()->create();
    Abonelik::factory()->for($this->uye)->create(['baslangic' => '2026-10-01', 'bitis' => '2026-10-20']);
    Abonelik::factory()->for($baska)->create(['baslangic' => '2026-10-01', 'bitis' => null]);
    Abonelik::factory()->for($baska)->iptal()->create(['baslangic' => '2026-10-01', 'bitis' => '2026-10-10']);

    // Yenilenmiş: 12 Ekim'de biten dönemin ardından ikinci dönem tanımlı.
    $yenileyen = User::factory()->create();
    Abonelik::factory()->for($yenileyen)->create(['baslangic' => '2026-09-13', 'bitis' => '2026-10-12']);
    Abonelik::factory()->for($yenileyen)->create(['baslangic' => '2026-10-13', 'bitis' => '2026-11-12']);

    $this->artisan('abonelik:bildir')->assertSuccessful();

    hicMailYok();
});

test('biten aboneliğe bir kez "sona erdi" gider; yenilenmişe ve çok eskiye gitmez', function () {
    $this->travelTo('2026-10-08 09:00');
    $biten = Abonelik::factory()->for($this->uye)->create(['baslangic' => '2026-09-07', 'bitis' => '2026-10-07']);

    $eski = User::factory()->create(['email' => 'eski@ornek.test']);
    $cokEski = Abonelik::factory()->for($eski)->create(['baslangic' => '2026-07-01', 'bitis' => '2026-07-31']);

    $yenileyen = User::factory()->create(['email' => 'yenileyen@ornek.test']);
    $yenilenen = Abonelik::factory()->for($yenileyen)->create(['baslangic' => '2026-09-07', 'bitis' => '2026-10-07']);
    Abonelik::factory()->for($yenileyen)->create(['baslangic' => '2026-10-08', 'bitis' => null]);

    $this->artisan('abonelik:bildir')->assertSuccessful();

    $mailler = kuyruktakiler();
    expect(array_keys($mailler))->toBe(['ayse@ornek.test'])
        ->and($mailler['ayse@ornek.test'][0]->konu)->toBe('Akademisyen aboneliğiniz sona erdi');

    // Üçü de işaretlendi: ikinci çalıştırmada hiçbirine gitmez.
    expect([$biten->fresh(), $cokEski->fresh(), $yenilenen->fresh()])
        ->each(fn ($a) => $a->bitis_bildirimi_gonderildi_at->not->toBeNull());

    Mail::fake();
    $this->artisan('abonelik:bildir')->assertSuccessful();
    hicMailYok();
});

test('kapatılan hatırlatma şablonu gitmez ama abonelik işaretlenir', function () {
    $this->travelTo('2026-10-08 09:00');
    EpostaSablonu::query()->create([
        'tur' => EpostaTuru::AbonelikBitiyor->value,
        'konu' => EpostaTuru::AbonelikBitiyor->varsayilanKonu(),
        'govde' => EpostaTuru::AbonelikBitiyor->varsayilanGovde(),
        'aktif' => false,
    ]);
    $abonelik = Abonelik::factory()->for($this->uye)->create(['plan' => Plan::Kurumsal, 'baslangic' => '2026-09-15', 'bitis' => '2026-10-12']);

    $this->artisan('abonelik:bildir')->assertSuccessful();

    expect(array_keys(kuyruktakiler()))->toBe(['admin@ornek.test'])
        ->and($abonelik->fresh()->hatirlatma_gonderildi_at)->not->toBeNull();
});

test('görev her gün 09:00\'da İstanbul saatiyle zamanlı', function () {
    $this->artisan('schedule:list')->expectsOutputToContain('abonelik:bildir')->assertSuccessful();

    $gorev = collect(app(Schedule::class)->events())
        ->first(fn ($e) => str_contains($e->command, 'abonelik:bildir'));

    expect($gorev->expression)->toBe('0 9 * * *')
        ->and($gorev->timezone)->toBe('Europe/Istanbul');
});
