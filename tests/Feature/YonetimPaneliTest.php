<?php

use App\Enums\Plan;
use App\Enums\YoneticiIslemi;
use App\Http\Controllers\TaklitController;
use App\Livewire\Admin\Abonelikler;
use App\Livewire\Admin\IslemKaydi as IslemKaydiEkrani;
use App\Livewire\Admin\KullaniciDetay;
use App\Livewire\Admin\Kullanicilar;
use App\Livewire\Admin\Pano;
use App\Models\Abonelik;
use App\Models\Faaliyet;
use App\Models\IslemKaydi;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->admin = User::factory()->onboarded()->create(['email' => 'admin@ornek.test', 'super_admin' => true]);
    $this->uye = User::factory()->onboarded()->create(['name' => 'Ayşe Yılmaz', 'email' => 'ayse@ornek.test']);
});

/** Yönetim paneli rotaları (kullanıcı detayı dahil). */
function yonetimRotalari(User $hedef): array
{
    return [
        route('admin.pano'), route('admin.kullanicilar'), route('admin.kullanici', $hedef),
        route('admin.abonelikler'), route('admin.islemler'),
    ];
}

// ── ERİŞİM ────────────────────────────────────────────────────────────────

test('misafir giriş sayfasına, normal kullanıcı 404\'e düşer; süper admin girer', function () {
    foreach (yonetimRotalari($this->uye) as $adres) {
        $this->get($adres)->assertRedirect(route('login'));
    }

    actingAs($this->uye);
    foreach (yonetimRotalari($this->uye) as $adres) {
        $this->get($adres)->assertNotFound();
    }

    actingAs($this->admin);
    foreach (yonetimRotalari($this->uye) as $adres) {
        $this->get($adres)->assertOk();
    }
});

test('süper admin olmak toplu atamayla mümkün değil', function () {
    $this->uye->update(['super_admin' => true, 'askiya_alindi_at' => now()]);

    expect($this->uye->fresh()->super_admin)->toBeFalse()
        ->and($this->uye->fresh()->askiya_alindi_at)->toBeNull();
});

test('askıdaki süper admin paneli açamaz', function () {
    $this->admin->forceFill(['askiya_alindi_at' => now()])->save();

    actingAs($this->admin)->get(route('admin.pano'))->assertRedirect(route('login'));
});

test('yönetim paneli bağlantısı yalnızca süper admine görünür', function () {
    actingAs($this->uye)->get(route('dashboard'))->assertDontSee('Yönetim Paneli');
    actingAs($this->admin)->get(route('dashboard'))->assertSee('Yönetim Paneli');
});

test('admin:yap komutu yetkiyi verir, geri alır ve kaydeder', function () {
    $this->artisan('admin:yap', ['eposta' => 'ayse@ornek.test'])->assertSuccessful();
    expect($this->uye->fresh()->super_admin)->toBeTrue();

    $this->artisan('admin:yap', ['eposta' => 'ayse@ornek.test', '--geri-al' => true])->assertSuccessful();
    expect($this->uye->fresh()->super_admin)->toBeFalse();

    expect(IslemKaydi::query()->where('hedef_user_id', $this->uye->id)->pluck('islem')->all())
        ->toBe([YoneticiIslemi::AdminYapildi, YoneticiIslemi::AdminligiAlindi]);

    $this->artisan('admin:yap', ['eposta' => 'yok@ornek.test'])->assertFailed();
});

// ── SON GİRİŞ ─────────────────────────────────────────────────────────────

test('giriş yapınca son giriş zamanı yazılır', function () {
    $this->post(route('login.store'), ['email' => 'ayse@ornek.test', 'password' => 'password']);

    expect($this->uye->fresh()->son_giris_at)->not->toBeNull();
});

// ── ASKIYA ALMA ───────────────────────────────────────────────────────────

test('askıya alınan kullanıcının oturumu kapanır, giriş sayfasında nedeni görür', function () {
    actingAs($this->admin);
    Livewire::test(KullaniciDetay::class, ['user' => $this->uye])
        ->set('askiNedeni', 'Ödeme itirazı')
        ->call('askiyaAl');

    expect($this->uye->fresh()->askidaMi())->toBeTrue();
    expect(IslemKaydi::query()->latest('id')->first())
        ->islem->toBe(YoneticiIslemi::AskiyaAldi)
        ->detay->toBe(['neden' => 'Ödeme itirazı'])
        ->hedef_eposta->toBe('ayse@ornek.test');

    actingAs($this->uye->fresh())->get(route('dashboard'))
        ->assertRedirect(route('login'))
        ->assertSessionHasErrors('email');
    $this->assertGuest();
});

test('askıdaki kullanıcının livewire isteği reddedilir', function () {
    $this->uye->forceFill(['askiya_alindi_at' => now()])->save();

    actingAs($this->uye)->withHeader('X-Livewire', 'true')->get(route('dashboard'))->assertForbidden();
});

test('askı kaldırılınca kullanıcı yeniden girer', function () {
    $this->uye->forceFill(['askiya_alindi_at' => now()])->save();

    actingAs($this->admin);
    Livewire::test(KullaniciDetay::class, ['user' => $this->uye])->call('askidanCikar');

    expect($this->uye->fresh()->askidaMi())->toBeFalse();
    actingAs($this->uye->fresh())->get(route('dashboard'))->assertOk();
});

test('kendi hesabı ve başka süper admin askıya alınamaz, silinemez', function (bool $kendisi) {
    $hedef = $kendisi ? $this->admin : User::factory()->create(['super_admin' => true]);

    actingAs($this->admin);
    Livewire::test(KullaniciDetay::class, ['user' => $hedef])
        ->call('askiyaAl')
        ->set('silmeOnayi', $hedef->email)
        ->call('sil')
        ->assertNoRedirect();

    expect($hedef->fresh())->not->toBeNull()
        ->and($hedef->fresh()->askidaMi())->toBeFalse();
})->with(['kendi hesabı' => true, 'başka süper admin' => false]);

// ── KULLANICI OLARAK GÖR ──────────────────────────────────────────────────

test('kullanıcı olarak gör: oturum kullanıcıya geçer, şerit görünür, geri dönülür; ikisi de kaydedilir', function () {
    actingAs($this->admin)
        ->post(route('admin.taklit.baslat', $this->uye))
        ->assertRedirect(route('dashboard'));

    $this->assertAuthenticatedAs($this->uye);
    expect(session(TaklitController::OTURUM_ANAHTARI))->toBe($this->admin->id);

    $this->get(route('dashboard'))
        ->assertSee('olarak görüntülüyorsunuz')
        ->assertSee('Yönetime dön');

    // Taklit, kullanıcının "son giriş"ini değiştirmez.
    expect($this->uye->fresh()->son_giris_at)->toBeNull();

    $this->post(route('taklit.bitir'))->assertRedirect(route('admin.kullanici', $this->uye));
    $this->assertAuthenticatedAs($this->admin);
    expect(session()->has(TaklitController::OTURUM_ANAHTARI))->toBeFalse();

    expect(IslemKaydi::query()->orderBy('id')->pluck('islem')->all())
        ->toBe([YoneticiIslemi::KullaniciOlarakGirdi, YoneticiIslemi::KullaniciOlarakCikti]);
});

test('süper admin, askıdaki hesap ve kendi hesabı taklit edilemez', function () {
    $digerAdmin = User::factory()->create(['super_admin' => true]);
    $askida = User::factory()->create(['askiya_alindi_at' => now()]);

    actingAs($this->admin);
    foreach ([$digerAdmin, $askida, $this->admin] as $hedef) {
        $this->post(route('admin.taklit.baslat', $hedef))->assertForbidden();
    }

    $this->assertAuthenticatedAs($this->admin);
});

test('normal kullanıcı taklit başlatamaz, taklitte değilken bitiremez', function () {
    actingAs($this->uye)->post(route('admin.taklit.baslat', $this->admin))->assertNotFound();
    actingAs($this->uye)->post(route('taklit.bitir'))->assertForbidden();
});

test('yetkisi taklit sırasında alınan yönetici geri dönemez', function () {
    actingAs($this->admin)->post(route('admin.taklit.baslat', $this->uye));
    $this->admin->forceFill(['super_admin' => false])->save();

    $this->post(route('taklit.bitir'))->assertForbidden();
    $this->assertAuthenticatedAs($this->uye);
});

// ── SİLME ─────────────────────────────────────────────────────────────────

test('silme e-posta onayı ister; onaylanınca kullanıcı, verisi ve dosyaları gider, kayıt kalır', function () {
    Storage::fake('local');
    Storage::disk('local')->put('profil-fotolar/a.jpg', 'x');
    $this->uye->forceFill(['profil_foto' => 'profil-fotolar/a.jpg'])->save();
    Faaliyet::factory()->for($this->uye)->count(3)->create();
    Abonelik::factory()->for($this->uye)->create();

    actingAs($this->admin);
    $bilesen = Livewire::test(KullaniciDetay::class, ['user' => $this->uye])
        ->set('silmeOnayi', 'yanlis@ornek.test')
        ->call('sil')
        ->assertHasErrors('silmeOnayi');

    expect($this->uye->fresh())->not->toBeNull();

    $bilesen->set('silmeOnayi', 'ayse@ornek.test')->call('sil')->assertRedirect(route('admin.kullanicilar'));

    expect($this->uye->fresh())->toBeNull()
        ->and(Faaliyet::query()->where('user_id', $this->uye->id)->count())->toBe(0)
        ->and(Abonelik::query()->where('user_id', $this->uye->id)->count())->toBe(0);
    Storage::disk('local')->assertMissing('profil-fotolar/a.jpg');

    $kayit = IslemKaydi::query()->where('islem', YoneticiIslemi::KullaniciyiSildi)->sole();
    expect($kayit->hedef_user_id)->toBeNull()
        ->and($kayit->hedef_eposta)->toBe('ayse@ornek.test')
        ->and($kayit->detay)->toBe(['ad' => 'Ayşe Yılmaz', 'faaliyet_sayisi' => 3]);
});

// ── ABONELİK ──────────────────────────────────────────────────────────────

test('abonelik yoksa ücretsiz plan; bir aylık abonelik bitiş günü dahil aktiftir', function () {
    expect($this->uye->plan())->toBe(Plan::Ucretsiz);

    $this->travelTo('2026-10-08');
    actingAs($this->admin);
    Livewire::test(KullaniciDetay::class, ['user' => $this->uye])
        ->assertSet('baslangic', '2026-10-08')
        ->set('plan', 'akademisyen')
        ->set('sure', '1')
        ->assertSet('tutar', '299')
        ->call('abonelikEkle')
        ->assertHasNoErrors();

    $abonelik = $this->uye->abonelikler()->sole();
    expect($abonelik->bitis->toDateString())->toBe('2026-11-07')
        ->and($abonelik->tutar_kurus)->toBe(29900)
        ->and($abonelik->olusturan_id)->toBe($this->admin->id)
        ->and($this->uye->plan())->toBe(Plan::Akademisyen);

    $this->travelTo('2026-11-07');
    expect($this->uye->fresh()->plan())->toBe(Plan::Akademisyen);

    $this->travelTo('2026-11-08');
    expect($this->uye->fresh()->plan())->toBe(Plan::Ucretsiz)
        ->and($abonelik->fresh()->durum())->toBe('bitti');
});

test('uzatma aktif aboneliğin ertesi gününden başlar; süre seçimi tutarı önerir', function () {
    $this->travelTo('2026-10-08');
    Abonelik::factory()->for($this->uye)->create(['baslangic' => '2026-10-01', 'bitis' => '2026-10-31']);

    actingAs($this->admin);
    Livewire::test(KullaniciDetay::class, ['user' => $this->uye])
        ->assertSet('baslangic', '2026-11-01')
        ->set('plan', 'kurumsal')
        ->set('sure', '12')
        ->assertSet('tutar', '11988')
        ->set('tutar', '9000,50')
        ->call('abonelikEkle')
        ->assertHasErrors('tutar')
        ->set('tutar', '9000.50')
        ->call('abonelikEkle')
        ->assertHasNoErrors();

    $yeni = $this->uye->abonelikler()->where('plan', 'kurumsal')->sole();
    expect($yeni->baslangic->toDateString())->toBe('2026-11-01')
        ->and($yeni->bitis->toDateString())->toBe('2027-10-31')
        ->and($yeni->tutar_kurus)->toBe(900050)
        ->and($yeni->durum())->toBe('baslamadi');
});

test('süresiz ve özel bitişli abonelik; bitiş başlangıçtan önce olamaz', function () {
    actingAs($this->admin);
    $bilesen = Livewire::test(KullaniciDetay::class, ['user' => $this->uye])
        ->set('baslangic', '2026-10-08')
        ->set('sure', 'ozel')
        ->set('bitis', '2026-10-01')
        ->call('abonelikEkle')
        ->assertHasErrors('bitis')
        ->set('bitis', '2026-12-15')
        ->call('abonelikEkle')
        ->assertHasNoErrors()
        ->set('sure', 'suresiz')
        ->set('tutar', '')
        ->call('abonelikEkle')
        ->assertHasNoErrors();

    expect($this->uye->abonelikler()->orderBy('id')->get()->map(fn (Abonelik $a) => [$a->bitis?->toDateString(), $a->tutar_kurus])->all())
        ->toBe([['2026-12-15', 29900], [null, null]]);
});

test('ücretsiz plan abonelik olarak atanamaz', function () {
    actingAs($this->admin);
    Livewire::test(KullaniciDetay::class, ['user' => $this->uye])
        ->set('plan', 'ucretsiz')
        ->call('abonelikEkle')
        ->assertHasErrors('plan');

    expect($this->uye->abonelikler()->count())->toBe(0);
});

test('abonelik iptal edilince kullanıcı ücretsize düşer, kayıt yazılır', function () {
    $abonelik = Abonelik::factory()->for($this->uye)->create();

    actingAs($this->admin);
    Livewire::test(KullaniciDetay::class, ['user' => $this->uye])->call('abonelikIptal', $abonelik->id);

    expect($abonelik->fresh()->durum())->toBe('iptal')
        ->and($this->uye->fresh()->plan())->toBe(Plan::Ucretsiz)
        ->and(IslemKaydi::query()->latest('id')->first()->islem)->toBe(YoneticiIslemi::AbonelikIptalEtti);
});

test('başka kullanıcının aboneliği bu sayfadan iptal edilemez', function () {
    $baskasinin = Abonelik::factory()->create();

    actingAs($this->admin);
    expect(fn () => Livewire::test(KullaniciDetay::class, ['user' => $this->uye])->call('abonelikIptal', $baskasinin->id))
        ->toThrow(ModelNotFoundException::class);

    expect($baskasinin->fresh()->iptal_edildi_at)->toBeNull();
});

// ── LİSTELER ──────────────────────────────────────────────────────────────

test('kullanıcı listesi arama, plan ve durumla süzülür', function () {
    Abonelik::factory()->for($this->uye)->create(['plan' => Plan::Kurumsal]);
    $askida = User::factory()->create(['name' => 'Askıdaki Hoca', 'askiya_alindi_at' => now()]);

    actingAs($this->admin);
    $adlar = fn ($bilesen) => $bilesen->get('kullanicilar')->pluck('name')->all();

    $liste = Livewire::test(Kullanicilar::class)->set('arama', 'ayse@');
    expect($adlar($liste))->toBe(['Ayşe Yılmaz']);

    $liste = Livewire::test(Kullanicilar::class)->set('plan', 'kurumsal');
    expect($adlar($liste))->toBe(['Ayşe Yılmaz']);

    $liste = Livewire::test(Kullanicilar::class)->set('plan', 'ucretsiz');
    expect($adlar($liste))->not->toContain('Ayşe Yılmaz')->toContain('Askıdaki Hoca');

    $liste = Livewire::test(Kullanicilar::class)->set('durum', 'askida');
    expect($adlar($liste))->toBe(['Askıdaki Hoca']);

    $liste = Livewire::test(Kullanicilar::class)->set('durum', 'admin');
    expect($liste->get('kullanicilar')->pluck('id')->all())->toBe([$this->admin->id]);
});

test('abonelikler sayfası süresi yaklaşanları ve bitenleri ayırır', function () {
    $yaklasan = Abonelik::factory()->create(['bitis' => now()->addDays(5)->toDateString()]);
    $uzak = Abonelik::factory()->create(['bitis' => now()->addDays(60)->toDateString()]);
    $biten = Abonelik::factory()->bitmis()->create();

    actingAs($this->admin);
    $idler = fn (string $durum) => Livewire::test(Abonelikler::class)->set('durum', $durum)->get('abonelikler')->pluck('id')->all();

    expect($idler('yaklasan'))->toBe([$yaklasan->id])
        ->and($idler('aktif'))->toBe([$yaklasan->id, $uzak->id])
        ->and($idler('bitti'))->toBe([$biten->id]);
});

test('genel bakış sayıları ve süresi yaklaşanlar', function () {
    Abonelik::factory()->for($this->uye)->create(['bitis' => now()->addDays(3)->toDateString()]);
    Abonelik::factory()->for($this->uye)->bitmis()->create();
    User::factory()->create(['askiya_alindi_at' => now()]);

    actingAs($this->admin);
    $pano = Livewire::test(Pano::class);

    expect($pano->get('sayilar'))->toBe(['kullanici' => 3, 'yeni' => 3, 'abone' => 1, 'askida' => 1])
        ->and($pano->get('bitecekler')->pluck('user_id')->all())->toBe([$this->uye->id]);
});

test('işlem kaydı işlem türü ve e-postayla süzülür', function () {
    IslemKaydi::factory()->create(['islem' => YoneticiIslemi::AskiyaAldi, 'hedef_eposta' => 'ayse@ornek.test']);
    IslemKaydi::factory()->create(['islem' => YoneticiIslemi::AbonelikEkledi, 'hedef_eposta' => 'mehmet@ornek.test']);

    actingAs($this->admin);
    expect(Livewire::test(IslemKaydiEkrani::class)->set('islem', 'abonelik_ekledi')->get('kayitlar')->pluck('hedef_eposta')->all())
        ->toBe(['mehmet@ornek.test'])
        ->and(Livewire::test(IslemKaydiEkrani::class)->set('arama', 'ayse')->get('kayitlar')->pluck('hedef_eposta')->all())
        ->toBe(['ayse@ornek.test']);
});
