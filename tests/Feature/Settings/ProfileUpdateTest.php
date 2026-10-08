<?php

use App\Livewire\Settings\Profile;
use App\Models\User;
use App\Services\Scoring\Sart\SartDeposu;
use Livewire\Livewire;

test('profile page is displayed', function () {
    $this->actingAs($user = User::factory()->create());

    $this->get('/settings/profile')->assertOk();
});

test('profile information can be updated', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = Livewire::test(Profile::class)
        ->set('name', 'Test User')
        ->set('email', 'test@example.com')
        ->call('updateProfileInformation');

    $response->assertHasNoErrors();

    $user->refresh();

    expect($user->name)->toEqual('Test User');
    expect($user->email)->toEqual('test@example.com');
    expect($user->email_verified_at)->toBeNull();
});

test('akademik bilgiler güncellenebilir ve fakülte kaskadı çalışır', function () {
    $user = User::factory()->onboarded()->create();

    $this->actingAs($user);

    Livewire::test(Profile::class)
        ->assertSet('temelAlan', 'ilahiyat')
        ->assertSet('fakulte', 'İlahiyat Fakültesi')
        ->set('temelAlan', 'saglik')            // İlahiyat sağlıkta yok → sıfırlanır
        ->assertSet('fakulte', '')
        ->set('fakulte', 'Tıp Fakültesi')
        ->set('bolum', 'Cerrahi Tıp Bilimleri')
        ->set('universite', 'Hacettepe Üniversitesi')
        ->call('updateProfileInformation')
        ->assertHasNoErrors();

    $user->refresh();

    expect($user->universite)->toBe('Hacettepe Üniversitesi')
        ->and($user->temel_alan->value)->toBe('saglik')
        ->and($user->fakulte)->toBe('Tıp Fakültesi')
        ->and($user->bolum)->toBe('Cerrahi Tıp Bilimleri');
});

test('email verification status is unchanged when email address is unchanged', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = Livewire::test(Profile::class)
        ->set('name', 'Test User')
        ->set('email', $user->email)
        ->call('updateProfileInformation');

    $response->assertHasNoErrors();

    expect($user->refresh()->email_verified_at)->not->toBeNull();
});

test('user can delete their account', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = Livewire::test('settings.delete-user-form')
        ->set('password', 'password')
        ->call('deleteUser');

    $response
        ->assertHasNoErrors()
        ->assertRedirect('/');

    expect($user->fresh())->toBeNull();
    expect(auth()->check())->toBeFalse();
});

test('correct password must be provided to delete account', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = Livewire::test('settings.delete-user-form')
        ->set('password', 'wrong-password')
        ->call('deleteUser');

    $response->assertHasErrors(['password']);

    expect($user->fresh())->not->toBeNull();
});

test('akademik profil alanları kaydedilir ve şart ağacı profiline yansır', function () {
    $user = User::factory()->onboarded()->create();

    $this->actingAs($user);

    Livewire::test(Profile::class)
        ->set('akademik.program_dili', 'yabanci_dil_100')
        ->set('akademik.doktora_tarihi', '2019-06-15')
        ->set('akademik.docentlik_tarihi', '2024-03-01')
        ->set('akademik.yds_puani', '85')
        ->set('akademik.h_indeksi', '7')
        ->set('akademik.yurtdisi_ay', '6')
        ->call('updateProfileInformation')
        ->assertHasNoErrors();

    $user->refresh();

    expect($user->program_dili)->toBe('yabanci_dil_100')
        ->and($user->doktora_tarihi->toDateString())->toBe('2019-06-15')
        ->and($user->yds_puani)->toBe(85)
        ->and($user->h_indeksi)->toBe(7);

    // Motorun okuduğu profil nesnesine geçiyor mu?
    $profil = $user->sartProfili([]);

    expect($profil->yds)->toBe(85)
        ->and($profil->hIndeksi)->toBe(7)
        ->and($profil->yurtdisiAy)->toBe(6)
        ->and($profil->programDili)->toBe('yabanci_dil_100')
        ->and($profil->referansTarih('doktora')->toDateString())->toBe('2019-06-15')
        ->and($profil->referansTarih('son_atama'))->toBeNull();
});

test('boş bırakılan akademik alan null kalır (0 ile karıştırılmaz)', function () {
    // "0" kesin olumsuz, null belirsiz: motor bu ikisini farklı değerlendiriyor.
    $user = User::factory()->onboarded()->create(['h_indeksi' => 5]);

    $this->actingAs($user);

    Livewire::test(Profile::class)
        ->assertSet('akademik.h_indeksi', '5')
        ->set('akademik.h_indeksi', '')
        ->set('akademik.yurtdisi_ay', '0')
        ->call('updateProfileInformation')
        ->assertHasNoErrors();

    $user->refresh();

    expect($user->h_indeksi)->toBeNull()
        ->and($user->yurtdisi_ay)->toBe(0)
        ->and($user->sartProfili([])->hIndeksi)->toBeNull()
        ->and($user->sartProfili([])->yurtdisiAy)->toBe(0);
});

test('geçersiz akademik değer doğrulamaya takılır', function () {
    $user = User::factory()->onboarded()->create();

    $this->actingAs($user);

    Livewire::test(Profile::class)
        ->set('akademik.doktora_tarihi', now()->addYear()->toDateString())
        ->set('akademik.h_indeksi', '-3')
        ->set('akademik.program_dili', 'klingonca')
        ->call('updateProfileInformation')
        ->assertHasErrors(['akademik.doktora_tarihi', 'akademik.h_indeksi', 'akademik.program_dili']);
});

test('akademik unvan profilden görüntülenir ve güncellenir', function () {
    $user = User::factory()->create(['unvan' => 'Dr. Öğr. Üyesi', 'temel_alan' => 'sosyal']);

    $sayfa = Livewire::actingAs($user)->test(Profile::class);

    // Mevcut unvan forma yüklenmeli.
    expect($sayfa->get('unvan'))->toBe('Dr. Öğr. Üyesi');
    $sayfa->assertSee('Akademik Unvan');

    // Terfi edince güncellenebilmeli: Yönerge Analizi hedef kadroyu buradan
    // türetiyor, daha önce yalnızca onboarding'de sorulup bir daha
    // değiştirilemiyordu.
    $sayfa->set('unvan', 'Doç. Dr.')->call('updateProfileInformation')->assertHasNoErrors();

    expect($user->fresh()->unvan)->toBe('Doç. Dr.');
});

test('listede olmayan unvan reddedilir', function () {
    $user = User::factory()->create(['temel_alan' => 'sosyal']);

    Livewire::actingAs($user)->test(Profile::class)
        ->set('unvan', 'Rektör')
        ->call('updateProfileInformation')
        ->assertHasErrors('unvan');
});

test('tarih alanları forma Y-m-d olarak yüklenir', function () {
    $user = User::factory()->create([
        'temel_alan' => 'sosyal',
        'lisans_tarihi' => '2016-06-20',
        'doktora_tarihi' => '2023-09-15',
    ]);

    // Uygulama CarbonImmutable kullanıyor; somut sınıfa bakan bir kontrol
    // tarihi "2016-06-20 00:00:00" olarak stringe çeviriyor ve
    // input[type=date] onu reddedip alan boş görünüyordu.
    $sayfa = Livewire::actingAs($user)->test(Profile::class);

    expect($sayfa->get('akademik')['lisans_tarihi'])->toBe('2016-06-20')
        ->and($sayfa->get('akademik')['doktora_tarihi'])->toBe('2023-09-15');
});

test('profil doluluk oranı formdaki tüm alanları sayar', function () {
    $user = User::factory()->create([
        'temel_alan' => 'sosyal',
        'lisans_tarihi' => '2016-06-20',
        'doktora_tarihi' => '2023-09-15',
        'docentlik_tarihi' => '2028-01-01',
        'son_atama_tarihi' => '2024-09-01',
        'program_dili' => 'turkce',
        'yds_puani' => 80,
        'h_indeksi' => 5,
        'yurtdisi_ay' => 6,
    ]);

    expect($user->profilDoluluk())->toBe(100);
});

test('program seçimi yalnızca program bazlı yönergesi olan üniversitede çıkar', function () {
    $depo = new SartDeposu(
        esikVerisi: [
            ['anahtar' => 'a', 'universite' => 'Program Üni', 'kadro' => 'docentlik', 'alan' => 'fen',
                'birim' => 'A Programı', 'cetvel' => 'x', 'notlar' => '', 'sart' => ['tip' => 'beyan', 'aciklama' => 'x']],
            ['anahtar' => 'b', 'universite' => 'Düz Üni', 'kadro' => 'docentlik', 'alan' => 'fen',
                'birim' => null, 'cetvel' => 'x', 'notlar' => '', 'sart' => ['tip' => 'beyan', 'aciklama' => 'x']],
        ],
        cetvelVerisi: ['x' => ['maddeler' => []]],
    );
    app()->instance(SartDeposu::class, $depo);

    $programli = User::factory()->create(['temel_alan' => 'fen', 'universite' => 'Program Üni']);
    Livewire::actingAs($programli)->test(Profile::class)->assertSee('Program seçin...');

    // Programdan bağımsız yönergede kullanıcıyı gereksiz soruyla meşgul etme.
    $duz = User::factory()->create(['temel_alan' => 'fen', 'universite' => 'Düz Üni']);
    Livewire::actingAs($duz)->test(Profile::class)->assertDontSee('Program seçin...');
});

test('aynı alanda birden çok program varsa eşik ancak program seçilince bulunur', function () {
    $esik = fn (string $anahtar, ?string $birim) => [
        'anahtar' => $anahtar, 'universite' => 'Çok Programlı Üni', 'kadro' => 'docentlik',
        'alan' => 'muhendislik', 'birim' => $birim, 'cetvel' => 'x', 'notlar' => '',
        'sart' => ['tip' => 'beyan', 'aciklama' => $anahtar],
    ];

    $depo = new SartDeposu(
        esikVerisi: [$esik('bilgisayar', 'Bilgisayar'), $esik('endustri', 'Endüstri')],
        cetvelVerisi: ['x' => ['maddeler' => []]],
    );

    // Program seçilmemişse hangisinin doğru olduğu bilinemez → null.
    expect($depo->bul('Çok Programlı Üni', 'docentlik', 'muhendislik'))->toBeNull()
        ->and($depo->bul('Çok Programlı Üni', 'docentlik', 'muhendislik', 'Endüstri')['anahtar'])->toBe('endustri');

    // Tek eşik varsa program bilinmese de kullanılır.
    $tek = new SartDeposu(
        esikVerisi: [$esik('bilgisayar', 'Bilgisayar')],
        cetvelVerisi: ['x' => ['maddeler' => []]],
    );

    expect($tek->bul('Çok Programlı Üni', 'docentlik', 'muhendislik')['anahtar'])->toBe('bilgisayar');
});

test('profil sayfası durumu Yönerge Analizi ile aynı adla anıyor', function () {
    // Boş profil alanının sonucunu anlatan cümle, durumun ekrandaki adını
    // kullanıyor. Ad üç ekranda geçiyor; biri eskide kalırsa aday aynı şeyi
    // iki ayrı durum sanır.
    $this->actingAs(User::factory()->create());

    Livewire::test(Profile::class)
        ->assertSee('Kriter Onaylanmalı')
        ->assertDontSee('eksik bilgi');
});

test('ayarlar menüsünde profil seçili görünür; livewire güncellemesinden sonra da', function () {
    $this->actingAs(User::factory()->create());

    $secili = fn (string $html) => preg_match('/<a[^>]*data-current[^>]*>\s*(?:<[^>]+>\s*)*Profil/u', $html) === 1;

    expect($secili($this->get(route('profile.edit'))->getContent()))->toBeTrue();

    // Güncelleme isteği livewire/update'ten gelir; işaret rota adına bağlı olsaydı kaybolurdu.
    $bilesen = Livewire::test(Profile::class)->set('name', 'Yeni Ad');

    expect($secili($bilesen->html()))->toBeTrue();
});
