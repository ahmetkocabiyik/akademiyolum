<?php

use App\Livewire\Onboarding;
use App\Livewire\Settings\Profile;
use App\Models\Universite;
use App\Models\User;
use App\Services\Scoring\Sart\ProfilGereksinimleri;
use App\Services\Scoring\Sart\SartDeposu;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

/**
 * Akademik profil zorunluluğu: herkese aynı alanlar değil, adayın KENDİ
 * yönergesinin okuduğu ve unvanının kesin gerektirdiği alanlar istenir.
 */
function gereksinimDeposu(): SartDeposu
{
    return new SartDeposu(
        esikVerisi: [[
            'anahtar' => 'test-dr-ilahiyat', 'universite' => 'Test Üniversitesi',
            'kadro' => 'dr_ogr_uyesi', 'alan' => 'ilahiyat', 'birim' => null,
            'cetvel' => 'test-cetvel', 'notlar' => '',
            'sart' => ['tip' => 've', 'aciklama' => 'Asgari', 'cocuklar' => [
                ['tip' => 'adet', 'aciklama' => 'Doktoradan sonra 2 makale', 'maddeler' => ['*'], 'min_adet' => 2,
                    'donem' => ['baslangic' => 'doktora']],
                ['tip' => 'metrik', 'metrik' => 'yds', 'aciklama' => 'Yabancı dil',
                    'kademeler' => ['turkce' => 65, 'yabanci_dil_100' => 85]],
            ]],
        ]],
        cetvelVerisi: ['test-cetvel' => ['maddeler' => [
            'M1' => ['baslik' => 'Makale', 'kategori' => 'makale', 'puan' => 10],
        ]]],
    );
}

function eksikKullanici(array $alanlar = []): User
{
    return User::factory()->onboarded()->create([
        'universite' => 'Test Üniversitesi', 'unvan' => 'Arş. Gör.', 'temel_alan' => 'ilahiyat',
        'doktora_tarihi' => null, 'docentlik_tarihi' => null, 'son_atama_tarihi' => null,
        'lisans_tarihi' => null, 'program_dili' => null, 'yds_puani' => null,
        'h_indeksi' => null, 'yurtdisi_ay' => null,
        ...$alanlar,
    ]);
}

beforeEach(function () {
    Universite::factory()->create(['ad' => 'Test Üniversitesi']);
    app()->instance(SartDeposu::class, gereksinimDeposu());
});

test('yönergenin okuduğu profil alanları gerekli sayılır', function () {
    $eksik = app(ProfilGereksinimleri::class)->eksikler(eksikKullanici());

    // Dönem başlangıcı (doktora), yabancı dil puanı ve kademeli baraj için öğretim dili.
    expect(array_keys($eksik))->toEqualCanonicalizing(['doktora_tarihi', 'yds_puani', 'program_dili'])
        // Yönergenin aramadığı alan istenmez.
        ->and($eksik)->not->toHaveKey('h_indeksi');
});

test('unvan kesin gerektirdiği tarihleri ekler, doktora öğrencisine doçentlik sorulmaz', function () {
    $gereksinim = app(ProfilGereksinimleri::class);

    $docent = eksikKullanici(['universite' => null, 'unvan' => 'Doç. Dr.']);
    $ogrenci = eksikKullanici(['universite' => null, 'unvan' => 'Doktora Öğrencisi']);

    expect(array_keys($gereksinim->eksikler($docent)))->toEqualCanonicalizing(['doktora_tarihi', 'docentlik_tarihi', 'son_atama_tarihi'])
        ->and($gereksinim->eksikler($ogrenci))->toBe([]);
});

test('doldurulan alan eksik listesinden çıkar', function () {
    $user = eksikKullanici(['doktora_tarihi' => '2020-01-01', 'yds_puani' => 80, 'program_dili' => 'turkce']);

    expect(app(ProfilGereksinimleri::class)->eksikler($user))->toBe([]);
});

test('eksik profil her sayfada uyarı şeridi gösterir, profil sayfasında göstermez', function () {
    actingAs(eksikKullanici());

    $this->get(route('dashboard'))->assertOk()
        ->assertSee('Akademik profiliniz eksik')
        ->assertSee('Doktora / sanatta yeterlik')
        ->assertSee(route('profile.edit').'#akademik-profil', false);

    $this->get(route('faaliyetler'))->assertSee('data-profil-eksik', false);

    // Profil sayfasında şerit yok; alanların kendisi işaretli.
    $this->get(route('profile.edit'))->assertOk()
        ->assertDontSee('data-profil-eksik ', false)
        ->assertSee('data-profil-eksik-liste', false)
        ->assertSee('Doktora / sanatta yeterlik (gerekli)');
});

test('profil tamamsa uyarı çıkmaz', function () {
    actingAs(eksikKullanici(['doktora_tarihi' => '2020-01-01', 'yds_puani' => 80, 'program_dili' => 'turkce']));

    $this->get(route('dashboard'))->assertOk()->assertDontSee('data-profil-eksik', false);
});

test('profil kaydedilince gerekli işareti kalkar', function () {
    $user = eksikKullanici();

    Livewire::actingAs($user)->test(Profile::class)
        ->assertSee('(gerekli)')
        ->set('akademik.doktora_tarihi', '2020-01-01')
        ->set('akademik.yds_puani', '80')
        ->set('akademik.program_dili', 'turkce')
        ->call('updateProfileInformation')
        ->assertHasNoErrors()
        ->assertDontSee('(gerekli)');
});

test('kurulum bitince profil eksikse akademik profile yönlendirilir', function () {
    $user = User::factory()->create();
    actingAs($user);

    Livewire::test(Onboarding::class)
        ->set('name', 'Ayşe Kaya')
        ->set('unvan', 'Arş. Gör.')
        ->call('next')
        ->set('universite', 'Test Üniversitesi')
        ->set('temelAlan', 'ilahiyat')
        ->call('submit')
        ->assertRedirect(route('profile.edit').'#akademik-profil');
});

test('kurulumda gerekli alan yoksa dashboarda gider', function () {
    Universite::factory()->create(['ad' => 'Verisi Olmayan Üni']);
    actingAs(User::factory()->create());

    Livewire::test(Onboarding::class)
        ->set('name', 'Ayşe Kaya')
        ->set('unvan', 'Doktora Öğrencisi')
        ->call('next')
        ->set('universite', 'Verisi Olmayan Üni')
        ->set('temelAlan', 'ilahiyat')
        ->call('submit')
        ->assertRedirect(route('dashboard'));
});
