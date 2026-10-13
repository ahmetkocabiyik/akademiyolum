<?php

use App\Console\Commands\UniversiteBirimleriCek;
use App\Enums\TemelAlan;
use App\Livewire\Onboarding;
use App\Livewire\Settings\Profile;
use App\Models\Universite;
use App\Models\UniversiteBirimi;
use App\Models\User;
use App\Services\Scoring\Sart\SartDeposu;
use Database\Seeders\UniversiteSeeder;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

/** @param  array<string, list<string>>  $birimler  fakülte → programlar */
function universiteBirimleri(string $ad, array $birimler): Universite
{
    $universite = Universite::factory()->create(['ad' => $ad]);

    foreach ($birimler as $fakulte => $bolumler) {
        foreach ($bolumler as $bolum) {
            UniversiteBirimi::factory()->for($universite)->create(['fakulte' => $fakulte, 'bolum' => $bolum]);
        }
    }

    return $universite;
}

// ── ÇEKME KOMUTU ──────────────────────────────────────────────────────────

test('komut atlası sayfa sayfa okur, adları eşler ve dosyaya yazar', function () {
    Universite::factory()->create(['ad' => 'Abdullah Gül Üniversitesi']);
    Universite::factory()->create(['ad' => 'Bezmiâlem Vakıf Üniversitesi']);
    Universite::factory()->create(['ad' => 'Orta Doğu Teknik Üniversitesi']);

    $program = fn (string $uni, string $fakulte, string $bolum) => ['universiteAdi' => $uni, 'fymkAdi' => $fakulte, 'birimGrupAdi' => $bolum];

    Http::fake(['yokatlas.yok.gov.tr/*' => Http::sequence()
        ->push(['last' => false, 'content' => [
            $program('ABDULLAH GÜL ÜNİVERSİTESİ (KAYSERİ)', 'İKTİSADİ VE İDARİ BİLİMLER FAKÜLTESİ', 'İşletme'),
            $program('ABDULLAH GÜL ÜNİVERSİTESİ (KAYSERİ)', 'İKTİSADİ VE İDARİ BİLİMLER FAKÜLTESİ', 'İktisat'),
            $program('BEZM-İ ÂLEM VAKIF ÜNİVERSİTESİ (İSTANBUL)', 'TIP FAKÜLTESİ (İngilizce)', 'Tıp'),
        ]])
        ->push(['last' => true, 'content' => [
            $program('ORTA DOĞU TEKNİK ÜNİVERSİTESİ (ANKARA)', 'ODTÜ KUZEY KIBRIS KAMPUSU', 'Psikoloji'),
            $program('ORTA DOĞU TEKNİK ÜNİVERSİTESİ (ANKARA)', 'FEN-EDEBİYAT FAKÜLTESİ', 'Fizik'),
            $program('GİRNE ÜNİVERSİTESİ (KKTC-GİRNE)', 'HUKUK FAKÜLTESİ', 'Hukuk'),
        ]]),
    ]);

    $dosya = tempnam(sys_get_temp_dir(), 'birim');

    $this->artisan('universite:birimleri-cek', ['--dosya' => $dosya])
        ->expectsOutputToContain('GİRNE ÜNİVERSİTESİ (KKTC-GİRNE)')
        ->assertSuccessful();

    expect(json_decode(file_get_contents($dosya), true))->toBe([
        'Abdullah Gül Üniversitesi' => ['İktisadi ve İdari Bilimler Fakültesi' => ['İktisat', 'İşletme']],
        'Bezmiâlem Vakıf Üniversitesi' => ['Tıp Fakültesi' => ['Tıp']],
        'Orta Doğu Teknik Üniversitesi' => [
            'Fen-Edebiyat Fakültesi' => ['Fizik'],
            'ODTÜ Kuzey Kıbrıs Kampusu' => ['Psikoloji'],
        ],
    ]);

    Http::assertSentCount(2);
    Http::assertSent(fn (Request $istek) => $istek->url() === UniversiteBirimleriCek::ADRES && $istek['page'] === 1);

    unlink($dosya);
});

test('başlık harfi Türkçe I/İ ayrımını korur', function () {
    expect(UniversiteBirimleriCek::baslikHarfi('İLAHİYAT FAKÜLTESİ'))->toBe('İlahiyat Fakültesi')
        ->and(UniversiteBirimleriCek::baslikHarfi('ISPARTA MESLEK YÜKSEKOKULU'))->toBe('Isparta Meslek Yüksekokulu')
        ->and(UniversiteBirimleriCek::baslikHarfi('DİL VE TARİH-COĞRAFYA FAKÜLTESİ'))->toBe('Dil ve Tarih-Coğrafya Fakültesi');
});

test('repodaki veri dosyası seed edilir', function () {
    $this->seed(UniversiteSeeder::class);

    $adiyaman = Universite::query()->where('ad', 'Adıyaman Üniversitesi')->sole();

    expect($adiyaman->birimler()->where('fakulte', 'Tıp Fakültesi')->pluck('bolum')->all())->toBe(['Tıp'])
        ->and(UniversiteBirimi::query()->distinct()->count('universite_id'))->toBeGreaterThan(150);

    // Tekrar çalışması güvenli: silip yeniden yazar, çoğaltmaz.
    $sayi = UniversiteBirimi::query()->count();
    $this->seed(UniversiteSeeder::class);
    expect(UniversiteBirimi::query()->count())->toBe($sayi);
});

// ── EKRANLAR ──────────────────────────────────────────────────────────────

test('fakülte seçenekleri seçilen üniversitenin birimleridir, temel alana bakılmaz', function () {
    universiteBirimleri('Adıyaman Üniversitesi', [
        'Uluslararası Tıp Fakültesi' => ['Tıp'],
        'Kahta Meslek Yüksekokulu' => ['Bahçe Tarımı'],
    ]);

    actingAs(User::factory()->create());

    Livewire::test(Onboarding::class)
        ->set('step', 2)
        ->set('temelAlan', 'ilahiyat')
        ->set('universite', 'Adıyaman Üniversitesi')
        ->assertViewHas('fakulteler', ['Kahta Meslek Yüksekokulu', 'Uluslararası Tıp Fakültesi'])
        ->assertSee('Uluslararası Tıp Fakültesi')
        ->assertDontSee('İlahiyat Fakültesi');
});

test('verisi olmayan üniversitede temel alanın genel listesi gelir', function () {
    actingAs(User::factory()->create());

    Livewire::test(Onboarding::class)
        ->set('step', 2)
        ->set('temelAlan', 'saglik')
        ->set('universite', 'Listede Olmayan Üniversite')
        ->assertSee('Tıp Fakültesi');
});

test('bölüm seçenekleri üniversitenin programları ile genel bölüm listesidir', function () {
    universiteBirimleri('Adıyaman Üniversitesi', ['Tıp Fakültesi' => ['Tıp']]);

    actingAs(User::factory()->create());

    Livewire::test(Onboarding::class)
        ->set('step', 2)
        ->set('universite', 'Adıyaman Üniversitesi')
        ->set('fakulte', 'Tıp Fakültesi')
        ->assertViewHas('bolumler', ['Cerrahi Tıp Bilimleri', 'Dahili Tıp Bilimleri', 'Temel Tıp Bilimleri', 'Tıp']);
});

test('üniversite değişince eski listeden seçilmiş fakülte ve bölüm sıfırlanır', function () {
    universiteBirimleri('A Üniversitesi', ['Ziraat Fakültesi' => ['Bitki Koruma']]);
    universiteBirimleri('B Üniversitesi', ['Tıp Fakültesi' => ['Tıp']]);

    actingAs(User::factory()->create());

    Livewire::test(Onboarding::class)
        ->set('universite', 'A Üniversitesi')
        ->set('fakulte', 'Ziraat Fakültesi')
        ->set('bolum', 'Bitki Koruma')
        ->set('universite', 'B Üniversitesi')
        ->assertSet('fakulte', '')
        ->assertSet('bolum', '');
});

test('listede olmayan, elle yazılmış fakülte ve bölüm korunur ve kaydedilir', function () {
    universiteBirimleri('Adıyaman Üniversitesi', ['Tıp Fakültesi' => ['Tıp']]);

    $user = User::factory()->create(['universite' => 'Adıyaman Üniversitesi', 'temel_alan' => 'saglik']);
    actingAs($user);

    Livewire::test(Profile::class)
        ->set('fakulte', 'Sağlık Bilimleri Enstitüsü')
        ->set('bolum', 'Halk Sağlığı')
        ->set('temelAlan', 'fen')
        ->assertSet('fakulte', 'Sağlık Bilimleri Enstitüsü')
        ->assertSet('bolum', 'Halk Sağlığı')
        ->call('updateProfileInformation')
        ->assertHasNoErrors();

    expect($user->refresh()->fakulte)->toBe('Sağlık Bilimleri Enstitüsü')
        ->and($user->bolum)->toBe('Halk Sağlığı');
});

test('kapanan ve mükerrer üniversiteler listeden kaldırılır, data dosyasına geri girmez', function () {
    $gocu = require database_path('migrations/2026_10_13_132355_kapanan_universiteleri_kaldir.php');

    foreach ($gocu::KALDIRILANLAR as $ad) {
        Universite::factory()->create(['ad' => $ad]);
    }
    Universite::factory()->create(['ad' => 'Munzur Üniversitesi']);

    $gocu->up();

    expect(Universite::query()->pluck('ad')->all())->toBe(['Munzur Üniversitesi'])
        ->and(array_intersect(array_column(require database_path('data/universiteler.php'), 0), $gocu::KALDIRILANLAR))->toBe([]);
});

test('İzmir Kavram MYO yeni adına taşınır, yönergesi yeni adla bulunur', function () {
    $gocu = require database_path('migrations/2026_10_13_134158_izmir_kavram_adini_konak_yap.php');

    Universite::factory()->create(['ad' => $gocu::ESKI, 'yonerge_url' => 'https://ornek.test/kavram.pdf']);
    $uye = User::factory()->create(['universite' => $gocu::ESKI]);

    $gocu->up();

    expect(Universite::query()->sole()->only('ad', 'yonerge_url'))->toBe(['ad' => $gocu::YENI, 'yonerge_url' => 'https://ornek.test/kavram.pdf'])
        ->and($uye->refresh()->universite)->toBe($gocu::YENI)
        ->and(collect(app(SartDeposu::class)->esikler())->pluck('universite')->unique()->all())
        ->toContain($gocu::YENI)->not->toContain($gocu::ESKI);
});

test('seeder yeni adlı satırı önce açtıysa eski satır silinir, bağlantısı aktarılır', function () {
    $gocu = require database_path('migrations/2026_10_13_134158_izmir_kavram_adini_konak_yap.php');

    Universite::factory()->create(['ad' => $gocu::ESKI, 'yonerge_url' => 'https://ornek.test/kavram.pdf']);
    Universite::factory()->create(['ad' => $gocu::YENI]);

    $gocu->up();

    expect(Universite::query()->sole()->only('ad', 'yonerge_url'))->toBe(['ad' => $gocu::YENI, 'yonerge_url' => 'https://ornek.test/kavram.pdf']);
});

// ── TEMEL ALAN ────────────────────────────────────────────────────────────

test('temel alan listesinde yalnızca yönergenin tanımladığı alanlar ve "listede yok" seçeneği var', function () {
    actingAs(User::factory()->create());

    $bilesen = Livewire::test(Onboarding::class)
        ->set('step', 2)
        ->set('universite', 'Abdullah Gül Üniversitesi');

    $gruplar = $bilesen->instance()->temelAlanGruplari();

    expect(array_keys($gruplar['tanimli']))->toBe(['sosyal', 'fen', 'muhendislik', 'filoloji', 'mimarlik'])
        ->and($gruplar['tanimsiz'])->toHaveKey('ilahiyat')
        ->and(count($gruplar['tanimli']) + count($gruplar['tanimsiz']))->toBe(count(TemelAlan::cases()));

    $bilesen->assertSee('Alanım listede yok')
        ->assertDontSee('İlahiyat')
        ->assertDontSee('Bu yönergede tanımlı değil')
        ->assertDontSee('ölçüt tanımlamıyor');
});

test('"listede yok" seçilince seçili alan korunur ve bütün alanlar açılır', function () {
    actingAs(User::factory()->create());

    Livewire::test(Onboarding::class)
        ->set('step', 2)
        ->set('universite', 'Abdullah Gül Üniversitesi')
        ->set('temelAlan', 'fen')
        ->set('temelAlan', Onboarding::TUM_ALANLAR)
        ->assertSet('temelAlan', 'fen')
        ->assertSet('tumAlanlar', true)
        ->assertSee('İlahiyat')
        ->assertSee('Bu yönergede tanımlı değil')
        ->assertDontSee('Alanım listede yok')
        ->set('universite', 'Gebze Teknik Üniversitesi')
        ->assertSet('tumAlanlar', false);
});

test('"listede yok" kurulumda seçim sayılmaz; varsayılan alan hâlâ yönergeye uyar', function () {
    actingAs(User::factory()->create());

    Livewire::test(Onboarding::class)
        ->set('temelAlan', Onboarding::TUM_ALANLAR)
        ->assertSet('temelAlan', 'sosyal')
        ->assertSet('temelAlanSecildi', false);
});

test('yönergenin tanımlamadığı alan seçilebilir, uyarı gösterilir ve üniversite değişince alan korunur', function () {
    actingAs(User::factory()->create());

    Livewire::test(Onboarding::class)
        ->set('step', 2)
        ->set('universite', 'Abdullah Gül Üniversitesi')
        ->set('temelAlan', 'ilahiyat')
        ->assertSee('Abdullah Gül Üniversitesi yönergesi bu temel alan için ölçüt tanımlamıyor')
        ->set('universite', 'Listede Olmayan Üniversite')
        ->assertSet('temelAlan', 'ilahiyat')
        ->assertDontSee('ölçüt tanımlamıyor');
});

test('yönergesi olmayan üniversitede bütün alanlar tek grupta gelir', function () {
    actingAs(User::factory()->create(['universite' => 'Listede Olmayan Üniversite']));

    Livewire::test(Profile::class)
        ->assertDontSee('Bu yönergede tanımlı değil')
        ->assertDontSee('Alanım listede yok')
        ->assertSee('İlahiyat');
});

test('kurulumda elle seçilmemiş varsayılan alan yönergenin ilk alanına geçer, elle seçilen korunur', function () {
    actingAs(User::factory()->create());

    $saglik = 'Lokman Hekim Üniversitesi';
    expect(app(SartDeposu::class)->alanlar($saglik))->not->toContain('sosyal');

    Livewire::test(Onboarding::class)
        ->assertSet('temelAlan', 'sosyal')
        ->set('universite', $saglik)
        ->assertSet('temelAlan', 'saglik');

    Livewire::test(Onboarding::class)
        ->set('temelAlan', 'sosyal')
        ->set('universite', $saglik)
        ->assertSet('temelAlan', 'sosyal');
});
