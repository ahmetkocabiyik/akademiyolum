<?php

use App\Enums\Plan;
use App\Enums\YoneticiIslemi;
use App\Livewire\Admin\KullaniciDetay;
use App\Livewire\Admin\Paketler;
use App\Models\IslemKaydi;
use App\Models\Paket;
use App\Models\User;
use App\Services\Abonelik\PaketKatalogu;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->admin = User::factory()->onboarded()->create(['super_admin' => true]);
});

/** Panelde bir paketi kaydeder. */
function paketiKaydet(string $plan, array $alanlar)
{
    $bilesen = Livewire::test(Paketler::class);

    foreach ($alanlar as $alan => $deger) {
        $bilesen->set("paketler.{$plan}.{$alan}", $deger);
    }

    return $bilesen->call('kaydet', $plan);
}

// ── KATALOG ───────────────────────────────────────────────────────────────

test('tablo boşken üç paket varsayılanlarla oluşur', function () {
    expect(Paket::query()->count())->toBe(0);

    $paketler = app(PaketKatalogu::class)->hepsi();

    expect($paketler->keys()->all())->toBe(['ucretsiz', 'akademisyen', 'kurumsal'])
        ->and(Paket::query()->count())->toBe(3)
        ->and($paketler['akademisyen']->aylik_fiyat_kurus)->toBe(29900)
        ->and($paketler['akademisyen']->one_cikan)->toBeTrue()
        ->and(Plan::Kurumsal->etiket())->toBe('Kurumsal');
});

test('fiyat metni tam lirada kuruş yazmaz', function () {
    expect(Paket::fiyatMetni(29900))->toBe('₺299')
        ->and(Paket::fiyatMetni(129950))->toBe('₺1.299,50')
        ->and(Paket::fiyatMetni(0))->toBe('₺0');
});

// ── PANEL ─────────────────────────────────────────────────────────────────

test('paketler ekranı yalnızca süper admine açık', function () {
    actingAs(User::factory()->onboarded()->create())->get(route('admin.paketler'))->assertNotFound();
    actingAs($this->admin)->get(route('admin.paketler'))->assertOk()->assertSee(['Ücretsiz', 'Akademisyen', 'Kurumsal']);
});

test('paket kaydedilir: fiyat kuruşa, özellikler satırlara; işlem kaydına fiyat farkı yazılır', function () {
    actingAs($this->admin);

    paketiKaydet('akademisyen', [
        'ad' => 'Akademisyen Pro',
        'aylik' => '349.50',
        'yillik' => '3490',
        'ozellikler' => "  Sınırsız faaliyet \n\n YZ Danışman\n",
        'buton_metni' => 'Hemen Başla',
    ])->assertHasNoErrors()->assertSet('paketler.akademisyen.ozellikler', "Sınırsız faaliyet\nYZ Danışman");

    $paket = Paket::query()->where('plan', 'akademisyen')->sole();
    expect($paket->ad)->toBe('Akademisyen Pro')
        ->and($paket->aylik_fiyat_kurus)->toBe(34950)
        ->and($paket->yillik_fiyat_kurus)->toBe(349000)
        ->and($paket->ozellikler)->toBe(['Sınırsız faaliyet', 'YZ Danışman'])
        ->and($paket->buton_metni)->toBe('Hemen Başla')
        ->and($paket->guncelleyen_id)->toBe($this->admin->id)
        ->and($paket->yillikIndirim())->toBe(17);

    $kayit = IslemKaydi::query()->sole();
    expect($kayit->islem)->toBe(YoneticiIslemi::PaketGuncelledi)
        ->and($kayit->detay)->toMatchArray(['paket' => 'Akademisyen Pro', 'aylik' => '₺299 → ₺349,50', 'yillik' => 'yok → ₺3.490']);
});

test('ücretsiz paketin fiyatı her zaman sıfır kalır', function () {
    actingAs($this->admin);

    paketiKaydet('ucretsiz', ['aylik' => '50', 'yillik' => '500', 'ad' => 'Başlangıç'])->assertHasNoErrors();

    $paket = Paket::query()->where('plan', 'ucretsiz')->sole();
    expect($paket->aylik_fiyat_kurus)->toBe(0)
        ->and($paket->yillik_fiyat_kurus)->toBeNull()
        ->and($paket->ad)->toBe('Başlangıç');
});

test('geçersiz paket bilgisi kaydedilmez', function (string $alan, mixed $deger) {
    actingAs($this->admin);

    paketiKaydet('kurumsal', [$alan => $deger])->assertHasErrors("paketler.kurumsal.{$alan}");

    expect(Paket::query()->where('plan', 'kurumsal')->sole()->aylik_fiyat_kurus)->toBe(99900);
})->with([
    'boş ad' => ['ad', ''],
    'negatif fiyat' => ['aylik', '-5'],
    'boş aylık fiyat' => ['aylik', ''],
    'harfli fiyat' => ['yillik', 'bin'],
    'boş buton' => ['buton_metni', ''],
    'çok fazla özellik' => ['ozellikler', implode("\n", range(1, 13))],
]);

test('olmayan paket kaydedilemez', function () {
    actingAs($this->admin);

    Livewire::test(Paketler::class)->call('kaydet', 'altin')->assertNotFound();
});

// ── YANSIMALAR ────────────────────────────────────────────────────────────

test('tanıtım sayfası panelden beslenir: ad, fiyat, yıllık indirim, özellikler; satışta olmayan görünmez', function () {
    $this->get('/')->assertSee(['₺299', 'Akademisyen', 'En Popüler', 'Kurumsal', '₺999', 'İletişime Geç']);

    actingAs($this->admin);
    paketiKaydet('akademisyen', ['ad' => 'Doçent Paketi', 'aylik' => '399', 'yillik' => '3990', 'ozellikler' => "Jüri simülasyonu\nSınırsız analiz"]);
    paketiKaydet('kurumsal', ['satista' => false]);

    auth()->logout();
    $this->get('/')
        ->assertSee(['Doçent Paketi', '₺399', 'Yıllık ₺3.990', '%17 indirim', 'Jüri simülasyonu'])
        ->assertDontSee(['₺299', 'İletişime Geç', '₺999']);
});

test('paket adı değişince rozetler ve abonelik önerisi yeni bilgiyle çalışır', function () {
    actingAs($this->admin);
    paketiKaydet('kurumsal', ['ad' => 'Üniversite', 'aylik' => '1500', 'yillik' => '15000']);

    expect(Plan::Kurumsal->etiket())->toBe('Üniversite');

    $uye = User::factory()->create();
    Livewire::test(KullaniciDetay::class, ['user' => $uye])
        ->assertSee('Üniversite · ₺1.500/ay')
        ->set('plan', 'kurumsal')
        ->set('sure', '3')
        ->assertSet('tutar', '4500')
        // 12 ayda yıllık fiyat önerilir.
        ->set('sure', '12')
        ->assertSet('tutar', '15000');
});
