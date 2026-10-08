<?php

use App\Livewire\Settings\Profile;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    Storage::fake('local');

    $this->user = User::factory()->onboarded()->create(['name' => 'Ayşe Yılmaz']);
    actingAs($this->user);
});

test('profil sayfasında fotoğraf yükleme alanı var', function () {
    $this->get(route('profile.edit'))
        ->assertOk()
        ->assertSee('Fotoğraf yükle')
        ->assertSee('JPG, PNG veya WebP · en fazla 10 MB');
});

test('fotoğraf seçilince özel diske saklanır, avatar olayı yayınlanır', function () {
    Livewire::test(Profile::class)
        ->set('yeniFoto', UploadedFile::fake()->image('vesikalik.jpg', 400, 400))
        ->assertHasNoErrors()
        ->assertSet('yeniFoto', null)
        ->assertDispatched('profil-foto-guncellendi');

    $yol = $this->user->fresh()->profil_foto;

    expect($yol)->toStartWith('profil-fotolar/');
    Storage::disk('local')->assertExists($yol);

    $this->get(route('profil.foto'))->assertOk();
});

test('fotoğraf değiştirilince eski dosya silinir', function () {
    $bilesen = Livewire::test(Profile::class)->set('yeniFoto', UploadedFile::fake()->image('ilk.jpg'));
    $ilk = $this->user->fresh()->profil_foto;

    $bilesen->set('yeniFoto', UploadedFile::fake()->image('ikinci.png'));
    $ikinci = $this->user->fresh()->profil_foto;

    expect($ikinci)->not->toBe($ilk);
    Storage::disk('local')->assertMissing($ilk);
    Storage::disk('local')->assertExists($ikinci);
});

test('fotoğraf kaldırılınca dosya silinir, baş harflere dönülür', function () {
    $bilesen = Livewire::test(Profile::class)->set('yeniFoto', UploadedFile::fake()->image('vesikalik.jpg'));
    $yol = $this->user->fresh()->profil_foto;

    $bilesen->call('fotoKaldir')->assertDispatched('profil-foto-guncellendi', adres: null);

    expect($this->user->fresh()->profil_foto)->toBeNull();
    Storage::disk('local')->assertMissing($yol);
    $this->get(route('profil.foto'))->assertNotFound();
});

test('görsel olmayan ya da 10 MB üstü dosya kabul edilmez', function (UploadedFile $dosya) {
    Livewire::test(Profile::class)
        ->set('yeniFoto', $dosya)
        ->assertHasErrors('yeniFoto');

    expect($this->user->fresh()->profil_foto)->toBeNull();
})->with([
    'pdf' => fn () => UploadedFile::fake()->create('belge.pdf', 100, 'application/pdf'),
    'büyük' => fn () => UploadedFile::fake()->image('buyuk.jpg')->size(10241),
]);

test('profil formu fotoğraf yolunu yazamaz', function () {
    // Toplu atamaya kapalı: profil güncellemesi bir dosya yolu taşıyamaz.
    $this->user->update(['profil_foto' => 'baskasinin/dosyasi.jpg']);

    expect($this->user->fresh()->profil_foto)->toBeNull();
});

test('fotoğraf rotası yalnızca oturumdaki kullanıcının fotoğrafını verir', function () {
    Livewire::test(Profile::class)->set('yeniFoto', UploadedFile::fake()->image('vesikalik.jpg'));

    actingAs(User::factory()->onboarded()->create());
    $this->get(route('profil.foto'))->assertNotFound();

    auth()->logout();
    $this->get(route('profil.foto'))->assertRedirect(route('login'));
});

test('kenar çubuğu fotoğraf varsa onu, yoksa baş harfleri gösterir', function () {
    $this->get(route('dashboard'))->assertSee('AY')->assertDontSee(route('profil.foto'), escape: false);

    Livewire::test(Profile::class)->set('yeniFoto', UploadedFile::fake()->image('vesikalik.jpg'));

    $adres = $this->user->fresh()->profilFotoAdresi();

    $this->get(route('dashboard'))
        ->assertSee('src="'.e($adres).'"', escape: false)
        ->assertSee('profil-foto-guncellendi.window', escape: false);
});

test('kullanıcı silinince profil fotoğrafı da silinir', function () {
    Livewire::test(Profile::class)->set('yeniFoto', UploadedFile::fake()->image('vesikalik.jpg'));
    $yol = $this->user->fresh()->profil_foto;

    $this->user->fresh()->delete();

    Storage::disk('local')->assertMissing($yol);
});
