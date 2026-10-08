<?php

use App\Enums\YoneticiIslemi;
use App\Livewire\Admin\YonergeDetay;
use App\Livewire\Admin\Yonergeler;
use App\Livewire\Dashboard;
use App\Models\GizliYonerge;
use App\Models\IslemKaydi;
use App\Models\Universite;
use App\Models\User;
use App\Services\Scoring\Sart\SartDeposu;
use App\Services\Yonetim\YonergeOzeti;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->admin = User::factory()->onboarded()->create(['super_admin' => true]);
    $this->uni = 'Mersin Üniversitesi';
});

// ── ERİŞİM VE LİSTE ───────────────────────────────────────────────────────

test('yönerge ekranları yalnızca süper admine açık', function () {
    $uye = User::factory()->onboarded()->create();

    actingAs($uye)->get(route('admin.yonergeler'))->assertNotFound();
    actingAs($uye)->get(route('admin.yonerge', $this->uni))->assertNotFound();

    actingAs($this->admin)->get(route('admin.yonergeler'))->assertOk()->assertSee($this->uni);
    actingAs($this->admin)->get(route('admin.yonerge', $this->uni))->assertOk()->assertSee('Kadro × temel alan');
});

test('bilinmeyen üniversitenin detayı 404', function () {
    actingAs($this->admin)->get(route('admin.yonerge', 'Olmayan Üniversite'))->assertNotFound();
});

test('liste durum ve aramayla süzülür, kapsam ve kullanıcı sayısı görünür', function () {
    Universite::query()->create(['ad' => 'Hayali Üniversitesi', 'sehir' => 'Ankara', 'tur' => 'devlet']);
    User::factory()->onboarded()->count(2)->create();
    actingAs($this->admin);

    $bilesen = Livewire::test(Yonergeler::class);
    $satir = collect($bilesen->get('satirlar'))->firstWhere('ad', $this->uni);

    expect($satir['durum'])->toBe('dogrulandi')
        ->and($satir['kapsam'])->toBeGreaterThan(0)->toBeLessThanOrEqual(36)
        ->and($satir['kullanici'])->toBe(3);

    $bilesen->set('durum', 'yok');
    expect(collect($bilesen->get('satirlar'))->pluck('ad'))->toContain('Hayali Üniversitesi')->not->toContain($this->uni);

    $bilesen->set('durum', '')->set('arama', 'mersin');
    expect(collect($bilesen->get('satirlar'))->pluck('ad')->all())->toBe([$this->uni]);
});

test('kapsam hiçbir üniversitede 36\'yı aşmaz: matris dışı kadrolar sayılmaz (Aksaray: ziraat yok → 33)', function () {
    $satirlar = collect(app(YonergeOzeti::class)->satirlar());

    expect($satirlar->max('kapsam'))->toBe(YonergeOzeti::TAM_KAPSAM)
        ->and($satirlar->firstWhere('ad', 'Aksaray Üniversitesi')['kapsam'])->toBe(33);
});

test('detay matrisi 3 kadro × 12 alan', function () {
    actingAs($this->admin);

    $matris = Livewire::test(YonergeDetay::class, ['universite' => $this->uni])->get('matris');

    expect($matris)->toHaveCount(3)
        ->and(collect($matris)->every(fn (array $satir): bool => count($satir) === 12))->toBeTrue()
        ->and($matris['dr_ogr_uyesi']['ilahiyat']['durum'])->toBe('dogrulandi');
});

// ── YAYINDAN KALDIRMA ─────────────────────────────────────────────────────

test('gizlenen yönerge motordan, analizden ve kullanıcının panelinden kalkar; yayına alınınca döner', function () {
    $depo = app(SartDeposu::class);
    $uye = User::factory()->onboarded()->create();
    expect($depo->universiteler())->toContain($this->uni);

    actingAs($this->admin);
    Livewire::test(YonergeDetay::class, ['universite' => $this->uni])
        ->set('gizlemeNedeni', 'Doçent barajı kontrol ediliyor')
        ->call('gizle')
        ->assertHasNoErrors();

    $gizli = GizliYonerge::query()->sole();
    expect($gizli->universite)->toBe($this->uni)
        ->and($gizli->gizleyen_id)->toBe($this->admin->id)
        ->and($depo->universiteler())->not->toContain($this->uni)
        ->and($depo->gizliMi($this->uni))->toBeTrue();

    actingAs($uye);
    Livewire::test(Dashboard::class)->assertSee('yönergesi geçici olarak incelemede');

    actingAs($this->admin);
    Livewire::test(YonergeDetay::class, ['universite' => $this->uni])->call('yayinaAl');

    expect(GizliYonerge::query()->count())->toBe(0)
        ->and($depo->universiteler())->toContain($this->uni);

    actingAs($uye);
    Livewire::test(Dashboard::class)->assertDontSee('geçici olarak incelemede');

    expect(IslemKaydi::query()->orderBy('id')->pluck('islem')->all())
        ->toBe([YoneticiIslemi::YonergeGizledi, YoneticiIslemi::YonergeYayinaAldi])
        ->and(IslemKaydi::query()->orderBy('id')->first()->detay)
        ->toBe(['universite' => $this->uni, 'neden' => 'Doçent barajı kontrol ediliyor']);
});

test('neden yazmadan gizlenemez', function () {
    actingAs($this->admin);

    Livewire::test(YonergeDetay::class, ['universite' => $this->uni])
        ->call('gizle')
        ->assertHasErrors(['gizlemeNedeni' => 'required']);

    expect(GizliYonerge::query()->count())->toBe(0);
});

test('kendi örneğini kuran depo gizleme katmanı olmadan çalışır', function () {
    GizliYonerge::query()->create(['universite' => $this->uni, 'neden' => 'test']);

    expect(app(SartDeposu::class)->universiteler())->not->toContain($this->uni)
        ->and((new SartDeposu)->universiteler())->toContain($this->uni);
});

// ── KÜNYE ─────────────────────────────────────────────────────────────────

test('künye güncellenir, ad değişmez ve kayda yazılır', function () {
    Universite::query()->create(['ad' => $this->uni, 'sehir' => 'Mersin', 'tur' => 'devlet']);
    actingAs($this->admin);

    Livewire::test(YonergeDetay::class, ['universite' => $this->uni])
        ->assertSet('sehir', 'Mersin')
        ->set('sehir', 'İçel')
        ->set('tur', 'vakif')
        ->set('yonergeUrl', 'https://www.mersin.edu.tr/yonerge.pdf')
        ->call('kunyeKaydet')
        ->assertHasNoErrors();

    $kunye = Universite::query()->sole();
    expect($kunye->ad)->toBe($this->uni)
        ->and($kunye->sehir)->toBe('İçel')
        ->and($kunye->tur)->toBe('vakif')
        ->and($kunye->yonerge_url)->toBe('https://www.mersin.edu.tr/yonerge.pdf')
        ->and(IslemKaydi::query()->sole()->islem)->toBe(YoneticiIslemi::UniversiteGuncelledi);
});

test('künyede geçersiz tür ve bağlantı reddedilir', function () {
    actingAs($this->admin);

    Livewire::test(YonergeDetay::class, ['universite' => $this->uni])
        ->set('tur', 'ozel')
        ->set('yonergeUrl', 'javascript:alert(1)')
        ->call('kunyeKaydet')
        ->assertHasErrors(['tur', 'yonergeUrl']);
});
