<?php

use App\Enums\CvBolumu;
use App\Enums\CvSablonu;
use App\Enums\CvYaziTipi;
use App\Enums\Kategori;
use App\Livewire\CvOlusturucu;
use App\Models\CvProfili;
use App\Models\Faaliyet;
use App\Models\Universite;
use App\Models\User;
use App\Services\Scoring\Sart\SartDeposu;
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

test('iletişim bilgileri ikonlarıyla basılır; orcid kimlik ikonu alır', function () {
    $bilesen = Livewire::test(CvOlusturucu::class)
        ->set('telefon', '0532 000 00 00')
        ->set('sehir', 'Ankara')
        ->set('orcid', '0000-0002-1825-0097');

    $html = $bilesen->html();

    expect(substr_count($html, 'cv-iletisim-ikon'))->toBe(4)
        ->and($html)->toContain('data-flux-icon')
        ->and($html)->toContain('0532 000 00 00');

    $bilesen->assertSeeHtmlInOrder(['cv-iletisim-ikon', '0000-0002-1825-0097']);

    $orcidIkonu = Blade::render('<flux:icon name="identification" variant="micro" />');

    expect($html)->toContain(pathIzi($orcidIkonu));
});

test('boş iletişim alanı ikonsuz da basılmaz', function () {
    $html = Livewire::test(CvOlusturucu::class)
        ->set('telefon', '')
        ->set('sehir', '')
        ->set('orcid', '')
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
        ->assertSet('orcid', '0000-0002-1825-0097');

    $profil = $this->user->cvProfili()->sole();

    // Doktora tarihi biliniyorsa eğitim satırı taslak olarak açılır.
    expect($profil->egitimler)->toHaveCount(1)
        ->and($profil->egitimler[0]['derece'])->toBe('Doktora')
        ->and($profil->egitimler[0]['bitis'])->toBe('2019');
});

test('cv künyesi akademik profilden BAĞIMSIZ: cv düzenlemek profili değiştirmez', function () {
    // CV'de başka bir unvan seçmek (ör. kadrosu çıkmış ama profili henüz
    // güncellenmemiş aday) yönerge analizinin kadro hesabını değiştirmemeli.
    Livewire::test(CvOlusturucu::class)
        ->set('unvan', 'Doç. Dr.')
        ->set('kurum', 'Başka Üniversite');

    expect($this->user->cvProfili()->sole()->unvan)->toBe('Doç. Dr.')
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
        ->assertSeeHtml('data-secim="yaziTipiSec"')
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

test('şehir yerine adres soruluyor; uzun adres kabul edilir, cvye ve jsona yazılır', function () {
    $adres = 'Mersin Üniversitesi Çiftlikköy Kampüsü İlahiyat Fakültesi, Yenişehir / Mersin';

    $this->get(route('cv-olusturucu'))->assertSee('Adres')->assertDontSee('>Şehir<', escape: false);

    $bilesen = Livewire::test(CvOlusturucu::class)
        ->set('sehir', $adres)
        ->assertHasNoErrors()
        ->assertSee($adres);

    expect($this->user->cvProfili()->sole()->sehir)->toBe($adres);

    ob_start();
    $bilesen->instance()->jsonIndir()->sendContent();
    $veri = json_decode((string) ob_get_clean(), true);

    expect($veri['kunye']['adres'])->toBe($adres)
        ->and($veri['kunye'])->not->toHaveKey('sehir');

    $bilesen->set('sehir', str_repeat('a', 201))->assertHasErrors(['sehir' => 'max']);
});

test('künye alanları odaktan çıkınca sunucuya gider: blur, live olmadan kullanılmaz', function () {
    // Livewire 4.1+'da `wire:model.blur` yalnız tarayıcıdaki değeri günceller;
    // istek gitmez, "otomatik kayıt" sessizce bir sonraki eyleme kalır.
    $html = file_get_contents(resource_path('views/components/cv/form-paneli.blade.php'));

    expect($html)->not->toMatch('/wire:model\.blur/')
        ->and(substr_count($html, 'wire:model.live.blur='))->toBeGreaterThanOrEqual(9);
});

test('telefon alanı 05xx xxx xx xx maskesiyle çizilir', function () {
    $this->get(route('cv-olusturucu'))
        ->assertSee('x-mask="0999 999 99 99"', escape: false)
        ->assertSee('placeholder="05xx xxx xx xx"', escape: false);
});

test('maskeye uyan telefon saklanır, uymayan reddedilir ve saklanmaz', function (string $telefon, bool $gecerli) {
    $bilesen = Livewire::test(CvOlusturucu::class)->set('telefon', $telefon);

    if ($gecerli) {
        $bilesen->assertHasNoErrors();
        expect($this->user->cvProfili()->sole()->telefon)->toBe($telefon);
    } else {
        $bilesen->assertHasErrors(['telefon' => 'regex']);
        expect($this->user->cvProfili()->sole()->telefon)->toBeNull();
    }
})->with([
    'cep' => ['0532 123 45 67', true],
    'ofis' => ['0324 361 00 01', true],
    'boşluksuz' => ['05321234567', false],
    'eksik' => ['0532 123 45', false],
    'ülke kodlu' => ['+90 532 123 45 67', false],
]);

test('geçersiz alan kayıtlı değeri ezmez; başka bir alan kaydedilirken de korunur', function () {
    Livewire::test(CvOlusturucu::class)
        ->set('telefon', '0532 123 45 67')
        ->set('telefon', '0532 12')
        ->assertHasErrors(['telefon'])
        ->set('unvan', 'Doç. Dr.')
        ->set('sehir', str_repeat('a', 201))
        ->assertHasErrors(['sehir']);

    $profil = $this->user->cvProfili()->sole();

    expect($profil->telefon)->toBe('0532 123 45 67')
        ->and($profil->unvan)->toBe('Doç. Dr.')
        ->and($profil->sehir)->toBeNull();
});

test('telefon boş bırakılabilir', function () {
    Livewire::test(CvOlusturucu::class)
        ->set('telefon', '0532 123 45 67')
        ->set('telefon', '')
        ->assertHasNoErrors();

    expect($this->user->cvProfili()->sole()->telefon)->toBeNull();
});

test('orcid alanı her zaman orcid maskesiyle çizilir; web adresi sorulmaz', function () {
    $this->get(route('cv-olusturucu'))
        ->assertSee('x-mask="9999-9999-9999-999*"', escape: false)
        ->assertSee('placeholder="0000-0000-0000-0000"', escape: false)
        ->assertDontSee('ORCID / Web');
});

test('geçerli orcid büyük X ile saklanır; web adresi ve yanlış kontrol hanesi saklanmaz', function () {
    $bilesen = Livewire::test(CvOlusturucu::class)
        ->set('orcid', '0000-0002-1694-233x')
        ->assertHasNoErrors();

    expect($this->user->cvProfili()->sole()->orcid)->toBe('0000-0002-1694-233X');

    $bilesen->set('orcid', 'https://ahmet.example.edu')
        ->assertHasErrors(['orcid'])
        ->assertSee('ORCID kimliğini 0000-0000-0000-0000 biçiminde girin.');

    $bilesen->set('orcid', '0000-0002-1825-0098')
        ->assertHasErrors(['orcid'])
        ->assertSee('Bu ORCID kimliği geçerli değil');

    expect($this->user->cvProfili()->sole()->orcid)->toBe('0000-0002-1694-233X');
});

test('profildeki orcid cvye yalnızca geçerliyse taşınır', function (?string $profilde, ?string $cvde) {
    $this->user->update(['orcid' => $profilde]);
    $this->user->cvProfili()->delete();

    Livewire::test(CvOlusturucu::class)->assertSet('orcid', (string) $cvde);
})->with([
    'çıplak kimlik' => ['0000-0002-1825-0097', '0000-0002-1825-0097'],
    'orcid.org adresi' => ['https://orcid.org/0000-0002-1694-233x', '0000-0002-1694-233X'],
    'yanlış kontrol hanesi' => ['0000-0002-1825-0098', null],
    'web adresi' => ['https://ahmet.example.edu', null],
]);

test('migration orcid adreslerini kimliğe indirir, orcid olmayan değeri temizler', function () {
    $tasima = require database_path('migrations/'.collect(scandir(database_path('migrations')))
        ->first(fn (string $dosya) => str_contains($dosya, 'cv_profillerinde_web_yerine_orcid')));

    // Kayıtlar yeni şemayla açılıyor, sonra eski şemaya dönülüp eski değerler yazılıyor.
    $adres = CvProfili::factory()->create();
    $web = CvProfili::factory()->create();

    $tasima->down();

    DB::table('cv_profilleri')->where('id', $adres->id)->update(['web' => 'https://orcid.org/0000-0002-1694-233x']);
    DB::table('cv_profilleri')->where('id', $web->id)->update(['web' => 'https://ahmet.example.edu']);

    $tasima->up();

    expect($adres->refresh()->orcid)->toBe('0000-0002-1694-233X')
        ->and($web->refresh()->orcid)->toBeNull();
});

test('unvan elle yazılmaz, profildeki listeden seçilir', function () {
    $bilesen = Livewire::test(CvOlusturucu::class)
        ->assertSeeHtml('data-secim="unvan"')
        ->assertSee(User::UNVANLAR)
        ->set('unvan', 'Prof. Dr.')
        ->assertHasNoErrors();

    expect($this->user->cvProfili()->sole()->unvan)->toBe('Prof. Dr.');

    $bilesen->set('unvan', 'Prof. Dr. Dr. h.c.')->assertHasErrors(['unvan']);

    expect($this->user->cvProfili()->sole()->unvan)->toBe('Prof. Dr.');
});

test('listede olmayan eski unvan seçenek olarak kalır ve silinmez', function () {
    CvProfili::kullaniciIcin($this->user)->update(['unvan' => 'Uzm. Dr.']);

    Livewire::test(CvOlusturucu::class)
        ->assertSet('unvan', 'Uzm. Dr.')
        ->assertSeeHtml('data-deger="Uzm. Dr."')
        ->set('ozet', 'Başka bir alan kaydediliyor.');

    expect($this->user->cvProfili()->sole()->unvan)->toBe('Uzm. Dr.');
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

test('faaliyet listesindeki puan saklanan sütundan değil kendi cetvelinden gelir', function () {
    Universite::factory()->create(['ad' => 'Test Üniversitesi']);
    app()->instance(SartDeposu::class, new SartDeposu(
        esikVerisi: [[
            'anahtar' => 'test-dr-ilahiyat', 'universite' => 'Test Üniversitesi',
            'kadro' => 'dr_ogr_uyesi', 'alan' => 'ilahiyat', 'birim' => null,
            'cetvel' => 'test-cetvel', 'notlar' => '',
            'sart' => ['tip' => 'puan', 'rol' => 'toplam', 'aciklama' => 'Toplam',
                'maddeler' => ['*'], 'min_puan' => 50],
        ]],
        cetvelVerisi: ['test-cetvel' => ['maddeler' => [
            'M1' => ['baslik' => 'TR Dizin makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'puan' => 10],
        ]]],
    ));
    $this->user->update(['universite' => 'Test Üniversitesi', 'unvan' => 'Arş. Gör.']);
    $this->makale->update(['puan' => 0]);

    $bilesen = Livewire::test(CvOlusturucu::class)->set('sekme', 'faaliyet')->assertSee('TR Dizin · 10 pt');

    ob_start();
    $bilesen->instance()->jsonIndir()->sendContent();
    $veri = json_decode((string) ob_get_clean(), true);

    expect(collect($veri['faaliyetler'])->firstWhere('baslik', 'Anadolu Tasavvuf Geleneği')['puan'])->toBe(10);
});

test('doğum tarihi kaydedilir; geçersizse kayıtlı değer korunur', function () {
    $bilesen = Livewire::test(CvOlusturucu::class)->set('dogumTarihi', '1985-04-12');

    expect($this->user->cvProfili->refresh()->dogum_tarihi->toDateString())->toBe('1985-04-12');

    $bilesen->set('dogumTarihi', now()->addYear()->toDateString())->assertHasErrors('dogumTarihi');

    expect($this->user->cvProfili->refresh()->dogum_tarihi->toDateString())->toBe('1985-04-12');
});

test('eğitim satırı tez adı ve danışmanı taşır; eski satırlar yeni anahtarlarla açılır', function () {
    CvProfili::factory()->for($this->user)->create([
        // Tez adı eklenmeden önce kaydedilmiş satır.
        'egitimler' => [['derece' => 'Doktora', 'universite' => 'Ankara Üniversitesi', 'bolum' => 'Kelam', 'baslangic' => '2012', 'bitis' => '2018']],
    ]);

    $bilesen = Livewire::test(CvOlusturucu::class)
        ->assertSet('egitimler.0.tez_adi', '')
        ->set('egitimler.0.tez_adi', 'Mâtürîdî Kelamında Bilgi')
        ->set('egitimler.0.danisman', 'Prof. Dr. Ali Veli');

    expect($this->user->cvProfili->refresh()->egitimler[0])
        ->toMatchArray(['tez_adi' => 'Mâtürîdî Kelamında Bilgi', 'danisman' => 'Prof. Dr. Ali Veli']);

    $bilesen->assertSee('Tez: Mâtürîdî Kelamında Bilgi · Danışman: Prof. Dr. Ali Veli');
});

test('akademik unvan ve üyelik satırları eklenir, kaydedilir, silinir ve önizlemede görünür', function () {
    $bilesen = Livewire::test(CvOlusturucu::class)
        ->set('sekme', 'kariyer')
        ->call('unvanEkle')
        ->set('akademikUnvanlar.0.unvan', 'Doçent')
        ->set('akademikUnvanlar.0.kurum', 'ÜAK')
        ->set('akademikUnvanlar.0.alan', 'Kelam')
        ->set('akademikUnvanlar.0.yil', '2021')
        ->call('uyelikEkle')
        ->set('uyelikler.0.kurulus', 'Kelam Araştırmaları Derneği')
        ->set('uyelikler.0.gorev', 'Üye');

    $profil = $this->user->cvProfili->refresh();

    expect($profil->akademik_unvanlar)->toBe([['unvan' => 'Doçent', 'kurum' => 'ÜAK', 'alan' => 'Kelam', 'yil' => '2021']])
        ->and($profil->uyelikler[0]['kurulus'])->toBe('Kelam Araştırmaları Derneği');

    $bilesen->assertSee('Akademik Unvanlar')
        ->assertSee('Doçent — Kelam')
        ->assertSee('Bilimsel Kuruluş Üyelikleri');

    $bilesen->call('unvanSil', 0)->call('uyelikSil', 0);

    $profil->refresh();
    expect($profil->akademik_unvanlar)->toBe([])->and($profil->uyelikler)->toBe([]);
});

test('ilk oluşturmada doçentlik tarihi akademik unvan satırı olarak gelir', function () {
    $user = User::factory()->onboarded()->create(['docentlik_tarihi' => '2021-05-10']);

    expect(CvProfili::kullaniciIcin($user)->akademik_unvanlar)
        ->toBe([['unvan' => 'Doçent', 'kurum' => 'ÜAK', 'alan' => null, 'yil' => '2021']]);
});

test('json dışa aktarım yeni alanları içerir', function () {
    $bilesen = Livewire::test(CvOlusturucu::class)
        ->set('dogumTarihi', '1985-04-12')
        ->call('uyelikEkle')
        ->set('uyelikler.0.kurulus', 'Türk Felsefe Derneği');

    ob_start();
    $bilesen->instance()->jsonIndir()->sendContent();
    $veri = json_decode((string) ob_get_clean(), true);

    expect($veri['kunye']['dogum_tarihi'])->toBe('1985-04-12')
        ->and($veri['uyelikler'][0]['kurulus'])->toBe('Türk Felsefe Derneği')
        ->and($veri)->toHaveKey('akademik_unvanlar');
});
