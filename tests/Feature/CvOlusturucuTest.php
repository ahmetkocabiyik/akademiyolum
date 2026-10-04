<?php

use App\Enums\CvBolumu;
use App\Enums\CvSablonu;
use App\Enums\CvYaziTipi;
use App\Enums\Kategori;
use App\Livewire\CvOlusturucu;
use App\Models\CvProfili;
use App\Models\Faaliyet;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->user = User::factory()->onboarded()->create([
        'name' => 'Ahmet Yılmaz',
        'orcid' => '0000-0002-1825-0097',
        'doktora_tarihi' => '2019-06-15',
    ]);

    $this->makale = Faaliyet::factory()->for($this->user)->create([
        'kategori' => Kategori::Makale,
        'baslik' => 'Anadolu Tasavvuf Geleneği',
        'kaynak' => 'TR Dizin',
        'durum' => 'onaylandi',
    ]);

    $this->kitap = Faaliyet::factory()->for($this->user)->create([
        'kategori' => Kategori::Kitap,
        'baslik' => 'Mânevî Gelişim Üzerine',
        'durum' => 'onaylandi',
    ]);

    actingAs($this->user);
});

test('cv sayfasında uygulama imzası ve tarih yok', function () {
    Livewire::test(CvOlusturucu::class)
        ->assertDontSee('Akademiyolum ile oluşturuldu')
        ->assertDontSee(now()->translatedFormat('F Y'));
});

test('iletişim bilgileri ikonlarıyla basılır; orcid numarası kimlik, adres küre ikonu alır', function () {
    $bilesen = Livewire::test(CvOlusturucu::class)
        ->set('telefon', '0532 000 00 00')
        ->set('sehir', 'Ankara')
        ->set('web', '0000-0002-1825-0097');

    $html = $bilesen->html();

    expect(substr_count($html, 'cv-iletisim-ikon'))->toBe(4)
        ->and($html)->toContain('data-flux-icon')
        ->and($html)->toContain('0532 000 00 00');

    $bilesen->assertSeeHtmlInOrder(['cv-iletisim-ikon', '0000-0002-1825-0097']);

    // ORCID numarası ile web adresi farklı ikon alıyor.
    $orcidIkonu = Blade::render('<flux:icon name="identification" variant="micro" />');
    $kureIkonu = Blade::render('<flux:icon name="globe-alt" variant="micro" />');

    expect($html)->toContain(pathIzi($orcidIkonu));

    $bilesen->set('web', 'https://ahmet.example.edu');

    expect($bilesen->html())->toContain(pathIzi($kureIkonu))
        ->not->toContain(pathIzi($orcidIkonu));
});

test('boş iletişim alanı ikonsuz da basılmaz', function () {
    $html = Livewire::test(CvOlusturucu::class)
        ->set('telefon', '')
        ->set('sehir', '')
        ->set('web', '')
        ->html();

    expect(substr_count($html, 'cv-iletisim-ikon'))->toBe(1);
});

/** Bir ikonun ilk `d="…"` izi; ikonları adıyla değil çizimiyle ayırt etmek için. */
function pathIzi(string $svg): string
{
    preg_match('/ d="([^"]+)"/', $svg, $eslesme);

    return $eslesme[1];
}

test('cv sayfası açılır ve önizleme çizilir', function () {
    $this->get(route('cv-olusturucu'))
        ->assertOk()
        ->assertSee('CV Oluşturucu')
        ->assertSee('Ahmet Yılmaz')
        ->assertSee('Anadolu Tasavvuf Geleneği');
});

test('ilk açılışta cv akademik profilden doldurulur', function () {
    Livewire::test(CvOlusturucu::class)
        ->assertSet('ad', 'Ahmet Yılmaz')
        ->assertSet('kurum', 'Mersin Üniversitesi')
        ->assertSet('eposta', $this->user->email)
        ->assertSet('web', '0000-0002-1825-0097');

    $profil = $this->user->cvProfili()->sole();

    // Doktora tarihi biliniyorsa eğitim satırı taslak olarak açılır.
    expect($profil->egitimler)->toHaveCount(1)
        ->and($profil->egitimler[0]['derece'])->toBe('Doktora')
        ->and($profil->egitimler[0]['bitis'])->toBe('2019');
});

test('cv künyesi akademik profilden BAĞIMSIZ: cv düzenlemek profili değiştirmez', function () {
    // Aday CV'sinde "Dr." yazdırmak isteyebilir; bu, yönerge analizinin
    // kadro hesabını değiştirmemeli.
    Livewire::test(CvOlusturucu::class)
        ->set('unvan', 'Dr.')
        ->set('kurum', 'Başka Üniversite');

    expect($this->user->cvProfili()->sole()->unvan)->toBe('Dr.')
        ->and($this->user->fresh()->unvan)->toBe('Dr. Öğr. Üyesi')
        ->and($this->user->fresh()->universite)->toBe('Mersin Üniversitesi');
});

test('alanlar ayrı bir kaydet adımı olmadan saklanır', function () {
    Livewire::test(CvOlusturucu::class)->set('ozet', 'Tasavvuf alanında çalışıyorum.');

    expect($this->user->cvProfili()->sole()->ozet)->toBe('Tasavvuf alanında çalışıyorum.');

    // Sayfa yeniden açıldığında değer yerinde.
    Livewire::test(CvOlusturucu::class)->assertSet('ozet', 'Tasavvuf alanında çalışıyorum.');
});

test('kaydet düğmesi formdaki değerleri saklar ve teyit verir', function () {
    Livewire::test(CvOlusturucu::class)
        ->set('unvan', 'Doç. Dr.')
        ->set('egitimler', [['derece' => 'Doktora', 'universite' => 'Ankara Üniversitesi', 'bolum' => 'Tasavvuf', 'baslangic' => '2013', 'bitis' => '2019']])
        ->call('kaydetVeBildir')
        ->assertDispatched('toast-show');

    $profil = $this->user->cvProfili()->sole();

    expect($profil->unvan)->toBe('Doç. Dr.')
        ->and($profil->egitimler[0]['universite'])->toBe('Ankara Üniversitesi');
});

test('yalnızca onaylı faaliyetler cv listesine girer', function () {
    Faaliyet::factory()->for($this->user)->create([
        'baslik' => 'Beklemedeki yayın',
        'durum' => 'beklemede',
    ]);

    $bilesen = Livewire::test(CvOlusturucu::class);

    expect($bilesen->instance()->faaliyetler()->pluck('baslik')->all())
        ->toContain('Anadolu Tasavvuf Geleneği')
        ->not->toContain('Beklemedeki yayın');

    $bilesen->assertDontSee('Beklemedeki yayın');
});

test('cvden çıkarılan faaliyet silinmez, yalnızca önizlemeden düşer', function () {
    $bilesen = Livewire::test(CvOlusturucu::class)
        ->call('faaliyetDegistir', $this->makale->id);

    expect($bilesen->instance()->secilenler()->pluck('id')->all())->toBe([$this->kitap->id])
        ->and($this->user->cvProfili()->sole()->haric_faaliyetler)->toBe([$this->makale->id])
        // Faaliyetin KENDİSİ duruyor: CV'den çıkarmak puanı silmek değil.
        ->and(Faaliyet::query()->whereKey($this->makale->id)->exists())->toBeTrue();

    // Aynı düğme geri alır.
    $bilesen->call('faaliyetDegistir', $this->makale->id);

    expect($bilesen->instance()->secilenler())->toHaveCount(2);
});

test('eğitim, deneyim, beceri ve dil satırları eklenip silinir', function () {
    $bilesen = Livewire::test(CvOlusturucu::class)
        ->call('egitimEkle')
        ->call('deneyimEkle')
        ->set('yeniBeceri', 'Tasavvuf')
        ->call('beceriEkle')
        ->set('yeniDil', 'Arapça')
        ->call('dilEkle');

    $profil = $this->user->cvProfili()->sole();

    expect($profil->egitimler)->toHaveCount(2) // taslak + eklenen
        ->and($profil->deneyimler)->toHaveCount(1)
        ->and($profil->beceriler)->toBe(['Tasavvuf'])
        ->and($profil->diller)->toBe([['ad' => 'Arapça', 'seviye' => 3]]);

    $bilesen->call('dilSeviye', 0, 5)->call('beceriSil', 0)->call('deneyimSil', 0);

    $profil->refresh();

    expect($profil->diller[0]['seviye'])->toBe(5)
        ->and($profil->beceriler)->toBe([])
        ->and($profil->deneyimler)->toBe([]);
});

test('aynı beceri iki kez eklenmez', function () {
    Livewire::test(CvOlusturucu::class)
        ->set('yeniBeceri', 'Kelam')->call('beceriEkle')
        ->set('yeniBeceri', 'Kelam')->call('beceriEkle')
        ->assertSet('yeniBeceri', '');

    expect($this->user->cvProfili()->sole()->beceriler)->toBe(['Kelam']);
});

test('dil seviyesi 1-5 aralığının dışına çıkamaz', function () {
    Livewire::test(CvOlusturucu::class)
        ->set('yeniDil', 'İngilizce')->call('dilEkle')
        ->call('dilSeviye', 0, 99);

    expect($this->user->cvProfili()->sole()->diller[0]['seviye'])->toBe(5);
});

test('şablon, renk ve yazı tipi yalnızca tanınan değerleri kabul eder', function () {
    $bilesen = Livewire::test(CvOlusturucu::class)
        ->call('sablonSec', 'prestijli')
        ->call('renkSec', CvProfili::RENKLER[2])
        ->call('yaziTipiSec', 'serif');

    $profil = $this->user->cvProfili()->sole();

    expect($profil->sablon)->toBe(CvSablonu::Prestijli)
        ->and($profil->renk)->toBe(CvProfili::RENKLER[2])
        ->and($profil->yazi_tipi)->toBe(CvYaziTipi::Serif);

    // Uydurma değerler sessizce yoksayılır: renk doğrudan style'a yazıldığı
    // için kapalı listeden çıkamaz.
    $bilesen->call('sablonSec', 'yok-boyle')->call('renkSec', 'red; background:url(x)')->call('yaziTipiSec', 'comic');

    $profil->refresh();

    expect($profil->sablon)->toBe(CvSablonu::Prestijli)
        ->and($profil->renk)->toBe(CvProfili::RENKLER[2])
        ->and($profil->yazi_tipi)->toBe(CvYaziTipi::Serif);
});

test('çizgi rengi seçilmemişse çizgiler gri basılır', function () {
    Livewire::test(CvOlusturucu::class)
        ->assertSet('cizgiRenk', CvProfili::VARSAYILAN_CIZGI_RENGI)
        ->assertSee('--cv-baslik-cizgi: #9ca3af;', escape: false)
        ->assertDontSee('Otomatik');
});

test('çizgi rengi seçilince saklanır ve sayfanın çizgilerine yazılır', function () {
    $bilesen = Livewire::test(CvOlusturucu::class)->call('cizgiRenkSec', '#dc2626');

    expect($this->user->cvProfili()->sole()->cizgi_renk)->toBe('#dc2626');

    $bilesen->assertSee('--cv-baslik-cizgi: #dc2626;', escape: false);

    // Sayfa yeniden açıldığında seçim yerinde.
    Livewire::test(CvOlusturucu::class)->assertSet('cizgiRenk', '#dc2626');
});

test('boş çizgi rengi kabul edilmez, seçim yerinde kalır', function () {
    Livewire::test(CvOlusturucu::class)
        ->call('cizgiRenkSec', '#dc2626')
        ->call('cizgiRenkSec', '')
        ->assertSet('cizgiRenk', '#dc2626');

    expect($this->user->cvProfili()->sole()->cizgi_renk)->toBe('#dc2626');
});

test('listede olmayan çizgi rengi yoksayılır', function () {
    Livewire::test(CvOlusturucu::class)
        ->call('cizgiRenkSec', '#16a34a')
        ->call('cizgiRenkSec', 'red; background:url(x)')
        ->assertSet('cizgiRenk', '#16a34a');

    expect($this->user->cvProfili()->sole()->cizgi_renk)->toBe('#16a34a');
});

test('veritabanında listeden çıkmış bir çizgi rengi style a yazılmaz', function () {
    CvProfili::kullaniciIcin($this->user)->forceFill(['cizgi_renk' => 'red;x:url(y)'])->save();

    Livewire::test(CvOlusturucu::class)->assertDontSee('red;x:url(y)', escape: false);
});

test('yalnızca minimal ve prestijli şablonlar sunulur; yeni cv minimal başlar', function () {
    expect(array_map(fn (CvSablonu $sablon) => $sablon->value, CvSablonu::cases()))->toBe(['minimal', 'prestijli']);

    Livewire::test(CvOlusturucu::class)
        ->assertSet('sablon', 'minimal')
        ->assertSee('Kurumsal')
        ->assertDontSee('Prestijli')
        ->assertDontSee('Resmî')
        ->call('sablonSec', 'resmi')
        ->call('sablonSec', 'sade')
        ->assertSet('sablon', 'minimal');

    expect($this->user->cvProfili()->sole()->sablon)->toBe(CvSablonu::Minimal);
});

test('kaldırılan şablonu seçmiş cv minimal e taşınır', function () {
    $resmi = CvProfili::factory()->create();
    $sade = CvProfili::factory()->create();
    $prestijli = CvProfili::factory()->create(['sablon' => CvSablonu::Prestijli]);

    DB::table('cv_profilleri')->where('id', $resmi->id)->update(['sablon' => 'resmi']);
    DB::table('cv_profilleri')->where('id', $sade->id)->update(['sablon' => 'sade']);

    $tasima = require database_path('migrations/'.collect(scandir(database_path('migrations')))
        ->first(fn (string $dosya) => str_contains($dosya, 'cv_sablonlarini_minimal_ve_prestijliye_indir')));
    $tasima->up();

    expect($resmi->refresh()->sablon)->toBe(CvSablonu::Minimal)
        ->and($sade->refresh()->sablon)->toBe(CvSablonu::Minimal)
        ->and($prestijli->refresh()->sablon)->toBe(CvSablonu::Prestijli);
});

test('yazı tipi açılır listeden seçilir; poppins, montserrat ve raleway de sunulur', function (string $deger, string $aile) {
    $bilesen = Livewire::test(CvOlusturucu::class)
        ->assertSeeHtml('<select')
        ->assertSee(['Poppins', 'Montserrat', 'Raleway'])
        ->call('yaziTipiSec', $deger);

    expect($this->user->cvProfili()->sole()->yazi_tipi)->toBe(CvYaziTipi::from($deger));

    $bilesen->assertSee("--cv-font: '{$aile}'");
})->with([
    ['poppins', 'Poppins'],
    ['montserrat', 'Montserrat'],
    ['raleway', 'Raleway'],
]);

test('cv sayfası web fontlarını türkçe harflerle ve başlık kalınlığıyla yükler', function () {
    $adres = CvYaziTipi::webFontlari();

    expect($adres)->toStartWith('https://fonts.bunny.net/')
        ->and($adres)->toContain('poppins:', 'montserrat:', 'raleway:')
        ->and(substr_count($adres, '800'))->toBe(3);

    Livewire::test(CvOlusturucu::class)->assertSeeHtml(e($adres));
});

test('kapatılan bölüm önizlemeden düşer ama verisi durur', function () {
    $bilesen = Livewire::test(CvOlusturucu::class)
        ->set('ozet', 'Gizlenecek biyografi')
        ->assertSee('Gizlenecek biyografi')
        ->call('bolumDegistir', CvBolumu::Ozet->value)
        ->assertDontSee('Gizlenecek biyografi');

    $profil = $this->user->cvProfili()->sole();

    expect($profil->bolumler[CvBolumu::Ozet->value])->toBeFalse()
        // Metin silinmedi: anahtar geri açılınca geri gelmeli.
        ->and($profil->ozet)->toBe('Gizlenecek biyografi');

    $bilesen->call('bolumDegistir', CvBolumu::Ozet->value)->assertSee('Gizlenecek biyografi');
});

test('json dışa aktarımı cvdeki faaliyetleri taşır, çıkarılanları taşımaz', function () {
    $bilesen = Livewire::test(CvOlusturucu::class)
        ->set('ozet', 'Özet metni')
        ->call('faaliyetDegistir', $this->kitap->id);

    $yanit = $bilesen->instance()->jsonIndir();

    ob_start();
    $yanit->sendContent();
    $veri = json_decode((string) ob_get_clean(), true);

    expect($veri['kunye']['ad'])->toBe('Ahmet Yılmaz')
        ->and($veri['kunye']['ozet'])->toBe('Özet metni')
        ->and(collect($veri['faaliyetler'])->pluck('baslik')->all())->toBe(['Anadolu Tasavvuf Geleneği']);
});

test('başka kullanıcının cvsi sızmaz', function () {
    $baskasi = User::factory()->create();
    CvProfili::factory()->for($baskasi)->create(['ozet' => 'gizli biyografi']);

    Livewire::test(CvOlusturucu::class)->assertDontSee('gizli biyografi');
});

test('fotoğraf seçilince özel diske saklanır ve önizlemede baş harflerin yerini alır', function () {
    Storage::fake('local');

    $bilesen = Livewire::test(CvOlusturucu::class)
        ->set('yeniFoto', UploadedFile::fake()->image('vesikalik.jpg', 400, 500))
        ->assertHasNoErrors()
        ->assertSet('yeniFoto', null);

    $yol = $this->user->cvProfili()->sole()->foto;

    expect($yol)->toStartWith('cv-fotolar/');
    Storage::disk('local')->assertExists($yol);

    $bilesen->assertSee(route('cv-olusturucu.foto', ['v' => basename($yol)]), escape: false);

    $this->get(route('cv-olusturucu.foto'))->assertOk();
});

test('fotoğraf değiştirilince eski dosya silinir', function () {
    Storage::fake('local');

    $bilesen = Livewire::test(CvOlusturucu::class)
        ->set('yeniFoto', UploadedFile::fake()->image('ilk.jpg'));

    $ilk = $this->user->cvProfili()->sole()->foto;

    $bilesen->set('yeniFoto', UploadedFile::fake()->image('ikinci.png'));

    $ikinci = $this->user->cvProfili()->sole()->foto;

    expect($ikinci)->not->toBe($ilk);
    Storage::disk('local')->assertMissing($ilk);
    Storage::disk('local')->assertExists($ikinci);
});

test('fotoğraf kaldırılınca dosya silinir ve baş harflere dönülür', function () {
    Storage::fake('local');

    $bilesen = Livewire::test(CvOlusturucu::class)
        ->set('yeniFoto', UploadedFile::fake()->image('vesikalik.jpg'));

    $yol = $this->user->cvProfili()->sole()->foto;

    $bilesen->call('fotoKaldir');

    expect($this->user->cvProfili()->sole()->foto)->toBeNull();
    Storage::disk('local')->assertMissing($yol);
    $this->get(route('cv-olusturucu.foto'))->assertNotFound();
});

test('görsel olmayan ya da 10 MB üstü dosya fotoğraf olarak kabul edilmez', function (UploadedFile $dosya) {
    Storage::fake('local');

    Livewire::test(CvOlusturucu::class)
        ->set('yeniFoto', $dosya)
        ->assertHasErrors('yeniFoto');

    expect($this->user->cvProfili()->sole()->foto)->toBeNull();
})->with([
    'pdf' => fn () => UploadedFile::fake()->create('belge.pdf', 100, 'application/pdf'),
    'büyük' => fn () => UploadedFile::fake()->image('buyuk.jpg')->size(10241),
]);

test('10 MB altındaki telefon fotoğrafı kabul edilir', function () {
    Storage::fake('local');

    Livewire::test(CvOlusturucu::class)
        ->set('yeniFoto', UploadedFile::fake()->image('telefon.jpg')->size(8000))
        ->assertHasNoErrors();

    expect($this->user->cvProfili()->sole()->foto)->not->toBeNull();
});

test('fotoğraf rotası yalnızca oturumdaki adayın kendi fotoğrafını verir', function () {
    Storage::fake('local');

    Livewire::test(CvOlusturucu::class)
        ->set('yeniFoto', UploadedFile::fake()->image('vesikalik.jpg'));

    actingAs(User::factory()->onboarded()->create());
    $this->get(route('cv-olusturucu.foto'))->assertNotFound();

    auth()->logout();
    $this->get(route('cv-olusturucu.foto'))->assertRedirect(route('login'));
});

test('yazdırmada cv sayfasının arka plan renkleri korunur', function () {
    // Tarayıcı yazdırırken arka planı varsayılan olarak atıyor; bu kural
    // düşerse Prestijli'nin koyu başlık bandı PDF'te beyaz çıkar.
    $css = file_get_contents(resource_path('css/app.css'));

    preg_match('/@media print\s*\{(.*)\n\}/s', $css, $yazdirma);

    expect($yazdirma[1] ?? '')
        ->toMatch('/#cv-sayfa\s*\{[^}]*(?<!-)print-color-adjust:\s*exact/')
        ->toMatch('/#cv-sayfa\s*\{[^}]*-webkit-print-color-adjust:\s*exact/');
});
